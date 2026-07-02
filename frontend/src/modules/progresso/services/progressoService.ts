import api from '@/core/services/api'

export interface Progresso {
  id?: number
  usuario_id: number
  vocabulario_aprendido?: number
  flashcards_concluidos?: number
  quizes_concluidos?: number
  tempo_total_estudo?: number
  sequencia_atual?: number
  maior_sequencia?: number
  ultima_atividade?: string
  progresso_nivel?: any
  // Ainda não implementados no backend (ver plano de implementação).
  // Quando o backend passar a retornar esses campos, o front já vai
  // reconhecê-los automaticamente sem precisar de outra alteração aqui.
  taxa_acerto?: number
  progresso_geral?: number
}

export const progressoService = {
  getByUsuario(usuarioId: number) {
    return api.get(`/progresso/usuario/${usuarioId}`)
  },

  save(data: Progresso) {
    return api.post('/progresso', data)
  },

  incrementarFlashcards(usuario_id: number, quantidade = 1) {
    return api.post('/progresso/incrementar-flashcards', {
      usuario_id,
      quantidade,
    })
  },

  incrementarTempo(segundos: number, usuario_id: number) {
    return api.post('/progresso/incrementar-tempo', {
      usuario_id,
      segundos,
    })
  },
}