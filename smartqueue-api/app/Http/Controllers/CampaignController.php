<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Jobs\ProcessCampaignJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CampaignController extends Controller
{
    /**
     * Lista as campanhas com paginação.
     * Útil para a tabela do Frontend.
     */
    public function index()
    {
        // Retorna as campanhas paginadas de 10 em 10, ordenadas pelas mais recentes
        $campaigns = Campaign::orderBy('created_at', 'desc')->paginate(10);
        
        return response()->json($campaigns, 200);
    }

    /**
     * Cria e dispara uma nova campanha.
     */
    public function store(Request $request)
    {
        // 1. Validação estrita dos dados recebidos
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255', // Deixei required para evitar e-mails sem assunto
            'content' => 'required|string',
            'recipients' => 'required|array|min:1',
            'recipients.*.name' => 'required|string|max:255',
            'recipients.*.destination' => 'required|email|max:255', // Garante que seja um e-mail válido
        ]);

        // 2. Transaction para garantir consistência total no banco
        $campaign = DB::transaction(function () use ($validated) {
            
            // Cria o registro pai da Campanha
            $campaign = Campaign::create([
                'name' => $validated['name'],
                'subject' => $validated['subject'],
                'content' => $validated['content'],
                'status' => 'pending',
                'total_recipients' => count($validated['recipients']),
                'processed_recipients' => 0
            ]);

            // Prepara a lista de destinatários mapeando o array
            $recipientsData = array_map(function ($recipient) use ($campaign) {
                return [
                    'campaign_id' => $campaign->id,
                    'name' => $recipient['name'],
                    'destination' => $recipient['destination'], // Usando a coluna correta do banco
                    'status' => 'pending',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $validated['recipients']);

            // Bulk insert: Insere tudo em uma única query no MySQL (essencial para performance)
            $campaign->recipients()->insert($recipientsData);

            return $campaign;
        });

        // Despacha o Job para ser executado em segundo plano pela fila do Redis
        ProcessCampaignJob::dispatch($campaign);

        // 3. Retorna HTTP 202 (Accepted)
        return response()->json([
            'message' => 'Campanha registrada com sucesso! O envio foi iniciado em segundo plano.',
            'campaign_id' => $campaign->id,
            'total' => $campaign->total_recipients
        ], 202);
    }

    /**
     * Cancela uma campanha que está pendente ou processando.
     */
    public function cancel(int $id)
    {
        $campaign = Campaign::findOrFail($id);

        if (in_array($campaign->status, ['completed', 'failed', 'canceled'])) {
            return response()->json([
                'message' => "Esta campanha não pode ser cancelada pois seu status atual é: {$campaign->status}."
            ], 422);
        }

        // Atualiza o status para cancelado
        $campaign->update(['status' => 'canceled']);

        return response()->json([
            'message' => 'Solicitação de cancelamento enviada. A fila irá parar de processar os próximos registros.',
            'campaign_id' => $campaign->id
        ], 200);
    }
}