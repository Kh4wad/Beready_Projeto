import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAlert } from '@/shared/composables/useAlert'
import { API_BASE_URL } from '@/shared/config/env'
import { useI18n } from 'vue-i18n'

export function useForgotPassword() {
  const router = useRouter()
  const { success, error } = useAlert()
  const { t } = useI18n()
  const loading = ref(false)

  const form = ref({ email: '' })

  const handleSubmit = async () => {
    if (!form.value.email) {
      error(t('forgotPassword.emailRequired'))
      return
    }

    loading.value = true

    try {
      const response = await fetch(`${API_BASE_URL}/auth/forgot-password`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email: form.value.email }),
      })
      const data = await response.json()

      if (data.success) {
        success(t('forgotPassword.successMessage'))
        setTimeout(() => router.push('/login'), 2000)
      } else {
        error(data.message || t('forgotPassword.errorMessage'))
      }
    } catch (err) {
      error(t('errors.networkError'))
    } finally {
      loading.value = false
    }
  }

  return { form, loading, handleSubmit }
}
