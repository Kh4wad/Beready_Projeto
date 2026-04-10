import api from '@/core/services/api'
import type { Quiz, ApiResponse } from '@/core/types'

export const quizService = {
  // Listar quizes do usuário
  getByUsuario: (usuarioId: number): Promise<ApiResponse<Quiz[]>> => {
    return api.get(`/quizes?usuario_id=${usuarioId}`)
  },

  // Buscar quiz por ID
  getById: (id: number): Promise<ApiResponse<Quiz>> => {
    return api.get(`/quizes/view/${id}`)
  },

  // Criar quiz
  create: (data: Omit<Quiz, 'id' | 'criado_em' | 'atualizado_em'>): Promise<ApiResponse<Quiz>> => {
    return api.post('/quizes', data)
  },

  // Atualizar quiz
  update: (id: number, data: Partial<Omit<Quiz, 'id' | 'criado_em' | 'atualizado_em'>>): Promise<ApiResponse<Quiz>> => {
    return api.put(`/quizes/edit/${id}`, data)
  },

  // Deletar quiz
  delete: (id: number): Promise<ApiResponse<null>> => {
    return api.delete(`/quizes/delete/${id}`)
  },
}
