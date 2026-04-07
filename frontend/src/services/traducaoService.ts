import api from './api'

export interface Traducao {
  id?: number
  prompt_id: number
  texto_traduzido: string
  idioma_destino?: string
  pontuacao_confianca?: number
  servico_traducao?: string
  traducoes_alternativas?: string[]
}

export const traducaoService = {
  // Listar traduções por prompt
  getByPrompt: (promptId: number) => api.get(`/traducoes/prompt/${promptId}`),

  // Buscar tradução por ID
  getById: (id: number) => api.get(`/traducoes/view/${id}`),

  // Criar tradução
  create: (data: Traducao) => api.post('/traducoes', data),

  // Atualizar tradução
  update: (id: number, data: Partial<Traducao>) => api.put(`/traducoes/edit/${id}`, data),

  // Deletar tradução
  delete: (id: number) => api.delete(`/traducoes/delete/${id}`),
}
