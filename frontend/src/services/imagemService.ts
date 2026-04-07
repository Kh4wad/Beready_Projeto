import api from './api'

export interface Imagem {
  id?: number
  prompt_id: number
  traducao_id?: number
  url_imagem: string
  prompt_imagem?: string
  servico_geracao?: string
  qualidade_imagem?: string
  dimensoes?: string
}

export const imagemService = {
  // Listar imagens por prompt
  getByPrompt: (promptId: number) => api.get(`/imagens/prompt/${promptId}`),

  // Buscar imagem por ID
  getById: (id: number) => api.get(`/imagens/view/${id}`),

  // Criar imagem
  create: (data: Imagem) => api.post('/imagens', data),

  // Atualizar imagem
  update: (id: number, data: Partial<Imagem>) => api.put(`/imagens/edit/${id}`, data),

  // Deletar imagem
  delete: (id: number) => api.delete(`/imagens/delete/${id}`),
}
