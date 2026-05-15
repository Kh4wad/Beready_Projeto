// src/modules/frases/composables/useFrases.ts
import { ref } from 'vue'
import { fraseService } from '../services/fraseService'
import type { Frase } from '@/core/types'

export function useFrases(promptId: number) {
  const frases = ref<Frase[]>([])
  const loading = ref(false)
  const error = ref<string | null>(null)

  const fetchFrases = async () => {
    loading.value = true
    error.value = null
    try {
      const response = await fraseService.getByPrompt(promptId)
      // response.data é ApiResponse<Frase[]>
      if (response.data.success) {
        frases.value = response.data.data || []
      } else {
        error.value = response.data.message || 'Erro ao carregar frases'
      }
    } catch (err: any) {
      error.value = err.message || 'Erro na requisição'
    } finally {
      loading.value = false
    }
  }

  const createFrase = async (data: Omit<Frase, 'id' | 'criado_em'>) => {
    const response = await fraseService.create(data)
    if (response.data.success) {
      await fetchFrases()
      return response.data.data
    }
    throw new Error(response.data.message)
  }

  const deleteFrase = async (id: number) => {
    const response = await fraseService.delete(id)
    if (response.data.success) {
      await fetchFrases()
    } else {
      throw new Error(response.data.message)
    }
  }

  return { frases, loading, error, fetchFrases, createFrase, deleteFrase }
}
