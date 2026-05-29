import { useQueue, Campaign } from '../hooks/useQueue'
import { Mail, CheckCircle2, AlertCircle, Loader2, RefreshCw, XCircle } from 'lucide-react'

export function QueueTable() {
  const { data: campaigns, isLoading, isError, refetch } = useQueue()

  // 1. Estado de Carregamento
  if (isLoading) {
    return (
      <div className="flex flex-col items-center justify-center p-12 space-y-4 bg-slate-900 border border-slate-800 rounded-2xl w-full max-w-6xl">
        <Loader2 className="w-8 h-8 animate-spin text-emerald-400" />
        <p className="text-slate-400 font-medium font-sans">Buscando campanhas no Laravel...</p>
      </div>
    )
  }

  // 2. Estado de Erro
  if (isError) {
    return (
      <div className="p-8 bg-rose-500/10 border border-rose-500/20 text-rose-400 rounded-2xl w-full max-w-6xl space-y-4">
        <div className="flex items-center gap-2">
          <AlertCircle className="w-6 h-6" />
          <h3 className="text-lg font-bold font-sans">Falha ao conectar com o Laragon</h3>
        </div>
        <p className="text-sm text-slate-400 font-sans">
          Não foi possível acessar a API em <code className="text-rose-300 font-mono">/api/campaigns</code>. Verifique se o seu backend está rodando.
        </p>
        <button 
          onClick={() => refetch()}
          className="flex items-center gap-2 bg-rose-600 hover:bg-rose-500 text-white font-medium text-sm px-4 py-2 rounded-xl transition-colors cursor-pointer"
        >
          <RefreshCw className="w-4 h-4" /> Tentar Novamente
        </button>
      </div>
    )
  }

  // 3. Tratamento da Resposta (Garante compatibilidade se o Laravel mandar array puro ou objeto paginado)
  const campaignList: Campaign[] = Array.isArray(campaigns)
    ? campaigns
    : (campaigns as any)?.data || []

  return (
    <div className="w-full max-w-6xl bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-2xl">
      <div className="px-6 py-5 bg-linear-to-r from-slate-900 to-slate-850 border-b border-slate-800 flex justify-between items-center">
        <div>
          <h2 className="text-xl font-bold text-white tracking-tight font-sans">Monitor de Campanhas de E-mail</h2>
          <p className="text-sm text-slate-400 font-sans">Listagem de disparos controlados pelo ProcessCampaignJob</p>
        </div>
      </div>

      <div className="overflow-x-auto">
        <table className="w-full text-left border-collapse">
          <thead>
            <tr className="border-b border-slate-800 bg-slate-950/50 text-slate-400 text-xs font-semibold uppercase tracking-wider font-sans">
              <th className="px-6 py-4">ID</th>
              <th className="px-6 py-4">Campanha</th>
              <th className="px-6 py-4">Assunto do E-mail</th>
              <th className="px-6 py-4">Status</th>
            </tr>
          </thead>
          <tbody className="divide-y divide-slate-800/60 font-mono text-sm">
            {campaignList.length === 0 ? (
              <tr>
                <td colSpan={4} className="px-6 py-10 text-center text-slate-500 font-sans">
                  Nenhuma campanha encontrada no banco de dados.
                </td>
              </tr>
            ) : (
              campaignList.map((campaign) => (
                <tr key={campaign.id} className="hover:bg-slate-850/40 transition-colors">
                  <td className="px-6 py-4 whitespace-nowrap text-slate-500 font-bold">
                    #{campaign.id}
                  </td>
                  <td className="px-6 py-4 whitespace-nowrap text-slate-200 font-sans font-medium">
                    {campaign.name}
                  </td>
                  <td className="px-6 py-4 whitespace-nowrap text-slate-400 font-sans">
                    <div className="flex items-center gap-2">
                      <Mail className="w-4 h-4 text-slate-600" />
                      {campaign.subject}
                    </div>
                  </td>
<td className="px-6 py-4 whitespace-nowrap">
  <span className={`inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium border font-sans ${
    campaign.status === 'processing' || campaign.status === 'Processando'
      ? 'bg-blue-500/10 text-blue-400 border-blue-500/20' :
    campaign.status === 'pending' || campaign.status === 'Pendente'
      ? 'bg-amber-500/10 text-amber-400 border-amber-500/20' :
    campaign.status === 'completed' || campaign.status === 'Concluido'
      ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' :
      'bg-rose-500/10 text-rose-400 border-rose-500/20'
  }`}>
    {(campaign.status === 'processing' || campaign.status === 'Processando') && (
      <Loader2 className="w-3 h-3 animate-spin" />
    )}
    {(campaign.status === 'completed' || campaign.status === 'Concluido') && (
      <CheckCircle2 className="w-3 h-3" />
    )}
    {(campaign.status === 'cancelled' || campaign.status === 'Cancelado') && (
      <XCircle className="w-3 h-3" />
    )}
    {campaign.status}
  </span>
</td>
                </tr>
              ))
            )}
          </tbody>
        </table>
      </div>
    </div>
  )
}