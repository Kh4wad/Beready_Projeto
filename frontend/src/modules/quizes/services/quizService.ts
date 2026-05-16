import api from '@/core/services/api'
import type { Quiz, ApiResponse } from '@/core/types'

export const quizService = {
  // Listar quizes do usuário
  getByUsuario: (usuarioId: number) => {
    console.log('🔍 GET /quizes?usuario_id=', usuarioId)
    return api.get(`/quizes?usuario_id=${usuarioId}`)
  },

  // Buscar quiz por ID
  getById: (id: number) => {
    console.log('🔍 GET /quizes/view/', id)
    return api.get(`/quizes/view/${id}`)
  },

  // Criar quiz
  create: (data: Omit<Quiz, 'id' | 'criado_em' | 'atualizado_em'>) => {
    console.log('📤 POST /quizes', data)
    return api.post('/quizes', data)
  },

  // Atualizar quiz
  update: (id: number, data: Partial<Omit<Quiz, 'id' | 'criado_em' | 'atualizado_em'>>) => {
    console.log('📤 PUT /quizes/${id}', data)
    return api.put(`/quizes/${id}`, data)
  },

  // Deletar quiz
  delete: (id: number) => {
    console.log('📤 DELETE /quizes/${id}')
    return api.delete(`/quizes/${id}`)
  },
}
