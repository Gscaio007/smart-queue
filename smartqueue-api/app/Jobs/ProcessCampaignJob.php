<?php

namespace App\Jobs;

use App\Models\Campaign;
use App\Mail\CampaignEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ProcessCampaignJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Campaign $campaign;

    /**
     * O Construtor recebe o Model da Campanha.
     */
    public function __construct(Campaign $campaign)
    {
        $this->campaign = $campaign;
    }

    /**
     * Aqui fica a lógica que roda em segundo plano com logs de debug ativos.
     */
    public function handle(): void
    {
        // 1. Atualiza o status da campanha para processando
        $this->campaign->update(['status' => 'processing']);

        // 2. Busca os destinatários que ainda estão pendentes no banco
        $recipients = $this->campaign->recipients()->where('status', 'pending')->get();

        // [DEBUG 1]: Vamos ver no log quantos destinatários ele realmente achou no banco
        Log::info("DEBUG: A Campanha ID {$this->campaign->id} encontrou " . $recipients->count() . " destinatários pendentes.");

foreach ($recipients as $recipient) {
    // CHECAGEM DE CANCELAMENTO: Se o usuário cancelou a campanha pelo front/API, interrompe o laço na hora
    $this->campaign->refresh(); // Atualiza os dados do banco na memória do Job
    if ($this->campaign->status === 'canceled') {
        Log::info("Campanha ID {$this->campaign->id} foi CANCELADA pelo usuário durante o processamento.");
        break; // Quebra o laço e para de enviar e-mail pros que sobraram
    }

    try {
        // [DEBUG]: Usando agora a propriedade correta $recipient->destination
        Log::info("DEBUG: Tentando enviar e-mail para: {$recipient->destination}");

        $mailable = new CampaignEmail($this->campaign->subject, $this->campaign->content);
        
        // Enviando para destination
        Mail::to($recipient->destination)->send($mailable);

        $recipient->update(['status' => 'sent']);

    } catch (\Exception $e) {
        Log::error("DEBUG ERRO no envio para {$recipient->destination}: " . $e->getMessage());

        $recipient->update([
            'status' => 'failed',
            'error_message' => substr($e->getMessage(), 0, 255)
        ]);
    }

    $this->campaign->increment('processed_recipients');
}

        // 3. Finaliza a campanha
        $this->campaign->update(['status' => 'completed']);
        
        Log::info("Campanha ID {$this->campaign->id} processada e e-mails disparados com sucesso!");
    }
}