import { useQuery } from '@tanstack/react-query'
import { api } from '../services/api'


export interface Campaign {
  id: number
  name: string
  subject: string
  status: 'pending' | 'processing' | 'completed' | 'cancelled' | 'Pendente' | 'Processando' | 'Concluido' | 'Cancelado' | string
  total_recipients?: number 
  created_at?: string
}

async function fetchCampaignQueue(): Promise<Campaign[]> {
  const { data } = await api.get('/campaigns')
  return data
}

export function useQueue() {
  return useQuery({
    queryKey: ['campaignQueue'],
    queryFn: fetchCampaignQueue,
    refetchInterval: 3000, // att de status a cada 3 segundos
  })
}