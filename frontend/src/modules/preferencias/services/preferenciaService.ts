import api from '@/core/services/api'
import type { Preferencia, ApiResponse } from '@/core/types'

export const preferenciaService = {
  getByUsuario: (usuarioId: number) => {
    console.log('🔍 GET /preferencias/usuario/', usuarioId)
    return api.get(`/preferencias/usuario/${usuarioId}`)
  },

  save: (data: Omit<Preferencia, 'id'>) => {
    console.log('📤 POST /preferencias', data)
    return api.post('/preferencias', data)
  },
}
