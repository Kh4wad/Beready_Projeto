import api from './api'

export interface Frase {
  id?: number
  prompt_id: number
  frase_semelhante: string
  pontuacao_semelhante?: number
  tipo_frase?: string
  nivel_dificuldade?: string
}

export const fraseService = {
  // Listar frases por prompt
  getByPrompt: (promptId: number) => api.get(`/frases/prompt/${promptId}`),

  // Buscar frase por ID
  getById: (id: number) => api.get(`/frases/view/${id}`),

  // Criar frase
  create: (data: Frase) => api.post('/frases', data),

  // Atualizar frase
  update: (id: number, data: Partial<Frase>) => api.put(`/frases/edit/${id}`, data),

  // Deletar frase
  delete: (id: number) => api.delete(`/frases/delete/${id}`),
}
