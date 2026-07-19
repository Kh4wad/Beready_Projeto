import { ref, onMounted } from 'vue'
import { flashcardService } from '../services/flashcardService'
import { useAlert } from '@/shared/composables/useAlert'
import { useI18n } from 'vue-i18n'

export function useFlashcards() {
  const flashcards = ref<any[]>([])
  const loading = ref(false)
  const { success, error } = useAlert()
  const { t } = useI18n()

  const loadFlashcards = async (usuarioId: number) => {
    loading.value = true
    try {
      const response = await flashcardService.getByUsuario(usuarioId)
      flashcards.value = response.data.data || []
      return flashcards.value
    } catch (err: any) {
      console.error('Erro ao carregar flashcards:', err)
      error(t('flashcards.errorLoad'))
      flashcards.value = []
    } finally {
      loading.value = false
    }
  }

  const createFlashcard = async (data: any) => {
    loading.value = true
    try {
      const response = await flashcardService.create(data)
      success(t('flashcards.successCreate'))
      return response.data.data
    } catch (err: any) {
      error(err.response?.data?.message || t('flashcards.errorCreate'))
      throw err
    } finally {
      loading.value = false
    }
  }

  const updateFlashcard = async (id: number, data: any) => {
    loading.value = true
    try {
      const response = await flashcardService.update(id, data)
      success(t('flashcards.successUpdate'))
      return response.data.data
    } catch (err: any) {
      error(err.response?.data?.message || t('flashcards.errorUpdate'))
      throw err
    } finally {
      loading.value = false
    }
  }

  const deleteFlashcard = async (id: number) => {
    loading.value = true
    try {
      await flashcardService.delete(id)
      success(t('flashcards.successDelete'))
      return true
    } catch (err: any) {
      error(err.response?.data?.message || t('flashcards.errorDelete'))
      throw err
    } finally {
      loading.value = false
    }
  }

  return {
    flashcards,
    loading,
    loadFlashcards,
    createFlashcard,
    updateFlashcard,
    deleteFlashcard,
  }
}
