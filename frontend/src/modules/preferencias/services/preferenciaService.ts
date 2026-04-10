import api from '@/core/services/api'
import type { Preferencia, ApiResponse } from '@/core/types'

export interface Preferencia {
  id?: number
  usuario_id: number
  tema: 'claro' | 'escuro'
  modo_daltonico: boolean
  notificacoes_ativas: boolean
  som_ativo: boolean
  traducao_automatica: boolean
  preferencia_dificuldade: 'iniciante' | 'intermediario' | 'avancado' | 'adaptativo'
  meta_diaria_minutos: number
}

export const preferenciaService = {
  getByUsuario: (usuarioId: number): Promise<ApiResponse<Preferencia>> => {
    return api.get(`/preferencias/usuario/${usuarioId}`)
  },

  save: (data: Omit<Preferencia, 'id'>): Promise<ApiResponse<Preferencia>> => {
    return api.post('/preferencias', data)
  },
}
