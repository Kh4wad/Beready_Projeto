import { ref } from 'vue'
import { quizService } from '../services/quizService'
import type { Quiz, ApiResponse } from '@/core/types'
import { useAlert } from '@/shared/composables/useAlert'

export function useQuizes() {
  const quizes = ref<Quiz[]>([])
  const loading = ref(false)
  const { success, error } = useAlert()

  const loadQuizes = async (usuarioId: number) => {
    loading.value = true
    try {
      const response = await quizService.getByUsuario(usuarioId)
      if (response.data.success) {
        quizes.value = response.data.data || []
      } else {
        error(response.data.message || 'Erro ao carregar quizes')
      }
    } catch (err: any) {
      console.error('Erro ao carregar quizes:', err)
      error('Erro ao carregar quizes')
      quizes.value = []
    } finally {
      loading.value = false
    }
  }

  const createQuiz = async (data: Omit<Quiz, 'id' | 'criado_em' | 'atualizado_em'>) => {
    loading.value = true
    try {
      const response = await quizService.create(data)
      if (response.data.success) {
        success('Quiz criado com sucesso!')
        return response.data.data
      } else {
        throw new Error(response.data.message)
      }
    } catch (err: any) {
      error(err.response?.data?.message || 'Erro ao criar quiz')
      throw err
    } finally {
      loading.value = false
    }
  }

  const updateQuiz = async (
    id: number,
    data: Partial<Omit<Quiz, 'id' | 'criado_em' | 'atualizado_em'>>,
  ) => {
    loading.value = true
    try {
      const response = await quizService.update(id, data)
      if (response.data.success) {
        success('Quiz atualizado com sucesso!')
        return response.data.data
      } else {
        throw new Error(response.data.message)
      }
    } catch (err: any) {
      error(err.response?.data?.message || 'Erro ao atualizar quiz')
      throw err
    } finally {
      loading.value = false
    }
  }

  const deleteQuiz = async (id: number) => {
    loading.value = true
    try {
      const response = await quizService.delete(id)
      if (response.data.success) {
        success('Quiz excluído com sucesso!')
        return true
      } else {
        throw new Error(response.data.message)
      }
    } catch (err: any) {
      error(err.response?.data?.message || 'Erro ao excluir quiz')
      throw err
    } finally {
      loading.value = false
    }
  }

  return { quizes, loading, loadQuizes, createQuiz, updateQuiz, deleteQuiz }
}
