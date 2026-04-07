import api from './api'

export interface Tag {
  id?: number
  criado_por: number
  nome: string
  cor: string
  descricao?: string
  tag_sistema?: boolean
}

export const tagService = {
  // Listar todas as tags
  getAll: () => api.get('/tags'),

  // Buscar tags por usuário
  getByUsuario: (usuarioId: number) => api.get(`/tags/usuario/${usuarioId}`),

  // Buscar tag por ID
  getById: (id: number) => api.get(`/tags/view/${id}`),

  // Criar tag
  create: (data: Tag) => api.post('/tags', data),

  // Atualizar tag
  update: (id: number, data: Partial<Tag>) => api.put(`/tags/edit/${id}`, data),

  // Deletar tag
  delete: (id: number) => api.delete(`/tags/delete/${id}`),
}
