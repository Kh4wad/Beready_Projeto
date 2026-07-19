import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useAlert } from '@/shared/composables/useAlert'
import { promptService } from '@/modules/prompts/services/promptService'
import type { Prompt } from '@/core/types'
import { useI18n } from 'vue-i18n'

export function usePrompts() {
  const router = useRouter()
  const { success, error } = useAlert()
  const { t } = useI18n()
  const prompts = ref<Prompt[]>([])
  const loading = ref(false)
  const saving = ref(false)
  const modalOpen = ref(false)
  const editingPrompt = ref<Prompt | null>(null)

  const confirmModalVisible = ref(false)
  const promptToDelete = ref<Prompt | null>(null)
  const deleting = ref(false)

  const form = ref({
    texto_original: '',
    idioma_original: 'en',
    contexto: 'manual',
    sessao_id: '',
  })

  const getCurrentUserId = (): number | null => {
    const userData = localStorage.getItem('user')
    if (!userData) return null
    try {
      const user = JSON.parse(userData)
      return user.id
    } catch {
      return null
    }
  }

  const fetchPrompts = async (): Promise<void> => {
    const userId = getCurrentUserId()
    if (!userId) {
      prompts.value = []
      return
    }
    loading.value = true
    try {
      const response = await promptService.getByUsuario(userId)
      if (response.data.success) {
        prompts.value = response.data.data || []
      } else {
        prompts.value = []
        error(response.data.message || t('prompts.errorLoad'))
      }
    } catch (err: unknown) {
      const axiosError = err as {
        response?: {
          status?: number
          data?: { message?: string }
        }
        message?: string
      }
      if (axiosError.response?.status !== 400) {
        error(axiosError.response?.data?.message || axiosError.message || t('prompts.errorLoad'))
      }
      prompts.value = []
    } finally {
      loading.value = false
    }
  }

  const openModal = (): void => {
    editingPrompt.value = null
    form.value = { texto_original: '', idioma_original: 'en', contexto: 'manual', sessao_id: '' }
    modalOpen.value = true
  }

  const editPrompt = (prompt: Prompt): void => {
    editingPrompt.value = prompt
    form.value = {
      texto_original: prompt.texto_original,
      idioma_original: prompt.idioma_original || 'en',
      contexto: prompt.contexto || 'manual',
      sessao_id: prompt.sessao_id || '',
    }
    modalOpen.value = true
  }

  const closeModal = (): void => {
    modalOpen.value = false
  }

  const savePrompt = async (): Promise<void> => {
    const userId = getCurrentUserId()
    if (!userId) {
      error(t('prompts.userNotAuthenticated'))
      return
    }

    saving.value = true

    try {
      if (editingPrompt.value) {
        const response = await promptService.update(editingPrompt.value.id!, form.value)
        if (response.data.success) success(t('prompts.successUpdate'))
        else throw new Error(response.data.message)
      } else {
        const response = await promptService.create({ ...form.value, usuario_id: userId })
        if (response.data.success) success(t('prompts.successCreate'))
        else throw new Error(response.data.message)
      }
      await fetchPrompts()
      closeModal()
    } catch (err: unknown) {
      const axiosError = err as { response?: { data?: { message?: string } } }
      error(axiosError.response?.data?.message || t('prompts.errorSave'))
    } finally {
      saving.value = false
    }
  }

  const confirmDelete = (prompt: Prompt): void => {
    promptToDelete.value = prompt
    confirmModalVisible.value = true
  }

  const handleConfirmDelete = async (): Promise<void> => {
    if (!promptToDelete.value) return

    deleting.value = true
    try {
      const response = await promptService.delete(promptToDelete.value.id!)
      if (response.data.success) {
        success(t('prompts.successDelete'))
        await fetchPrompts()
      } else {
        throw new Error(response.data.message)
      }
    } catch (err: unknown) {
      const axiosError = err as { response?: { data?: { message?: string } } }
      error(axiosError.response?.data?.message || t('prompts.errorDelete'))
    } finally {
      deleting.value = false
      confirmModalVisible.value = false
      promptToDelete.value = null
    }
  }

  const formatDate = (date?: string): string => {
    if (!date) return ''
    return new Date(date).toLocaleDateString('pt-BR')
  }

  const viewTranslations = (promptId: number): void => {
    router.push(`/prompts/${promptId}`)
  }

  const getLanguageName = (code?: string): string => {
    const languages: Record<string, string> = {
      'pt-BR': t('idiomas.pt'),
      en: t('idiomas.en'),
      es: t('idiomas.es'),
      fr: t('idiomas.fr'),
    }
    return languages[code || ''] || code?.toUpperCase() || 'PT'
  }

  const getContextName = (context?: string): string => {
    const contexts: Record<string, string> = {
      manual: t('prompts.contextoManual'),
      conversacao: t('prompts.contextoConversacao'),
      negocios: t('prompts.contextoNegocios'),
      viagem: t('prompts.contextoViagem'),
      estudo: t('prompts.contextoEstudo'),
    }
    return contexts[context || ''] || context || t('prompts.contextoManual')
  }

  onMounted(() => {
    fetchPrompts()
  })

  return {
    prompts,
    loading,
    modalOpen,
    saving,
    form,
    editingPrompt,
    confirmModalVisible,
    promptToDelete,
    deleting,
    openModal,
    editPrompt,
    closeModal,
    savePrompt,
    confirmDelete,
    handleConfirmDelete,
    formatDate,
    viewTranslations,
    getLanguageName,
    getContextName,
  }
}
