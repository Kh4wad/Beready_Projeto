import { ref, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useAuth } from '@/shared/composables/useAuth'

export function useOAuthCallback() {
  const router = useRouter()
  const route = useRoute()
  const { loadUser } = useAuth()
  const error = ref<string | null>(null)
  const loading = ref(true)

  const handleCallback = async () => {
    try {
      const token = route.query.token as string
      const refreshToken = route.query.refresh_token as string
      const userData = route.query.user as string

      if (token && userData) {
        localStorage.setItem('access_token', token)
        localStorage.setItem('refresh_token', refreshToken)
        localStorage.setItem('user', userData)

        loadUser()

        if (window.opener) {
          window.opener.location.href = '/dashboard'
          window.close()
        } else {
          router.push('/dashboard')
        }
        return
      }

      error.value = 'Não foi possível autenticar com Google.'
      setTimeout(() => {
        router.push('/login')
      }, 2000)
    } catch (err) {
      console.error('Erro no callback OAuth:', err)
      error.value = 'Erro ao processar autenticação.'
    } finally {
      loading.value = false
    }
  }

  const goToLogin = () => {
    router.push('/login')
  }

  onMounted(() => {
    handleCallback()
  })

  return {
    error,
    loading,
    goToLogin,
  }
}
