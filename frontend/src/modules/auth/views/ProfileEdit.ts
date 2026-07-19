import { ref, computed, onMounted, watch } from 'vue'
import { useRouter } from 'vue-router'
import { useForm } from '@/shared/composables/useForm'
import { usePasswordStrength } from '@/shared/composables/usePasswordStrength'
import { usePhoneMask } from '@/shared/composables/usePhoneMask'
import { useAlert } from '@/shared/composables/useAlert'
import { API_BASE_URL } from '@/shared/config/env'
import { useI18n } from 'vue-i18n'

export function useProfileEdit() {
  const router = useRouter()
  const { success, error } = useAlert()
  const { t } = useI18n()
  const loading = ref(false)
  const showPassword = ref(false)
  const showConfirmPassword = ref(false)
  const userId = ref<number | null>(null)
  const selectedImage = ref<File | undefined>(undefined)

  const { strengthClass, strengthText, strengthWidth, checkPasswordStrength } =
    usePasswordStrength()
  const { handlePhoneInput, handlePhoneKeydown, phoneError, formatPhone } = usePhoneMask()

  const { form, errors, validate } = useForm({
    nome: '',
    email: '',
    telefone: '',
    foto_perfil: '',
    nivel_ingles: '',
    idioma_preferido: '',
    status: 'ativo',
    objetivos_aprendizado: '',
    nova_senha: '',
    confirmar_senha: '',
  })

  const passwordsMatch = computed(() => {
    if (!form.nova_senha && !form.confirmar_senha) return true
    return form.nova_senha === form.confirmar_senha
  })

  const imagePreview = ref<string | null>(null)

  watch(selectedImage, (newFile) => {
    if (newFile) {
      const reader = new FileReader()
      reader.onload = (e) => {
        imagePreview.value = e.target?.result as string
      }
      reader.readAsDataURL(newFile)
    } else {
      imagePreview.value = null
    }
  })

  const handlePasswordInput = (event: Event) => {
    const input = event.target as HTMLInputElement
    checkPasswordStrength(input.value)
  }

  const handleConfirmPasswordInput = () => {
    passwordsMatch.value
  }

  const handleImageChange = (event: Event) => {
    const input = event.target as HTMLInputElement

    if (!input.files || input.files.length === 0) {
      selectedImage.value = undefined
      return
    }

    const file = input.files[0]
    if (!file) {
      selectedImage.value = undefined
      return
    }

    selectedImage.value = file
  }

  const loadUserData = async () => {
    const userData = localStorage.getItem('user')
    if (!userData) {
      router.push('/login')
      return
    }

    try {
      const user = JSON.parse(userData)
      userId.value = user.id

      const response = await fetch(`${API_BASE_URL}/users/view/${user.id}`, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          Accept: 'application/json',
        },
      })

      if (response.ok) {
        const data = await response.json()
        if (data.success) {
          const userData = data.data?.user || data.user || data.data

          form.nome = userData.nome || ''
          form.email = userData.email || ''
          form.telefone = formatPhone(userData.telefone || '')
          form.foto_perfil = userData.foto_perfil || ''
          form.nivel_ingles = userData.nivel_ingles || 'iniciante'
          form.idioma_preferido = userData.idioma_preferido || 'pt-BR'
          form.status = userData.status || 'ativo'
          form.objetivos_aprendizado = userData.objetivos_aprendizado || ''
        }
      } else {
        const user = JSON.parse(userData)
        form.nome = user.nome || ''
        form.email = user.email || ''
        form.telefone = formatPhone(user.telefone || '')
        form.foto_perfil = user.foto_perfil || ''
        form.nivel_ingles = user.nivel_ingles || 'iniciante'
        form.idioma_preferido = user.idioma_preferido || 'pt-BR'
        form.status = user.status || 'ativo'
        form.objetivos_aprendizado = user.objetivos_aprendizado || ''
      }
    } catch (e) {
      const user = JSON.parse(userData)
      userId.value = user.id
      form.nome = user.nome || ''
      form.email = user.email || ''
      form.telefone = formatPhone(user.telefone || '')
      form.foto_perfil = user.foto_perfil || ''
      form.nivel_ingles = user.nivel_ingles || 'iniciante'
      form.idioma_preferido = user.idioma_preferido || 'pt-BR'
      form.status = user.status || 'ativo'
      form.objetivos_aprendizado = user.objetivos_aprendizado || ''
    }
  }

  const uploadImageToCloudinary = async (file: File): Promise<string | null> => {
    try {
      const formData = new FormData()
      formData.append('photo', file)

      const token = localStorage.getItem('access_token')

      const response = await fetch(`${API_BASE_URL}/upload/profile-photo`, {
        method: 'POST',
        headers: {
          Accept: 'application/json',
          Authorization: `Bearer ${token}`,
        },
        body: formData,
      })

      const data = await response.json()

      if (response.ok && data.success) {
        return data.url
      } else {
        console.error('Erro no upload:', data.message)
        return null
      }
    } catch (error) {
      console.error('Erro no upload:', error)
      return null
    }
  }

  const handleSubmit = async () => {
    let currentUserId = userId.value

    if (!currentUserId) {
      const userData = localStorage.getItem('user')
      if (userData) {
        const user = JSON.parse(userData)
        currentUserId = user.id
        userId.value = currentUserId
      }
    }

    if (!currentUserId) {
      error(t('errors.unauthorized'))
      router.push('/login')
      return
    }

    if (form.telefone) {
      const digits = form.telefone.replace(/\D/g, '')
      if (digits.length > 0 && digits.length < 11) {
        error(t('profile.telefoneInvalido') || 'Telefone deve ter 11 dígitos')
        return
      }
    }

    if (form.nova_senha) {
      if (form.nova_senha.length < 6) {
        error(t('errors.minLength', { min: 6 }))
        return
      }
      if (form.nova_senha !== form.confirmar_senha) {
        error(t('errors.passwordMatch'))
        return
      }
    }

    loading.value = true

    try {
      let uploadedImageUrl = form.foto_perfil

      if (selectedImage.value) {
        const url = await uploadImageToCloudinary(selectedImage.value)
        if (url) {
          uploadedImageUrl = url
          selectedImage.value = undefined
          imagePreview.value = null
        } else {
          error(t('profile.erroUploadImagem') || 'Erro ao fazer upload da imagem. Tente novamente.')
          loading.value = false
          return
        }
      }

      interface SubmitData {
        nome: string
        email: string
        telefone: string
        nivel_ingles: string
        idioma_preferido: string
        status: string
        objetivos_aprendizado: string
        foto_perfil: string
        senha?: string
      }

      const submitData: SubmitData = {
        nome: form.nome,
        email: form.email,
        telefone: form.telefone,
        nivel_ingles: form.nivel_ingles,
        idioma_preferido: form.idioma_preferido,
        status: form.status,
        objetivos_aprendizado: form.objetivos_aprendizado,
        foto_perfil: uploadedImageUrl,
      }

      if (form.nova_senha !== '') {
        submitData.senha = form.nova_senha
      }

      const response = await fetch(`${API_BASE_URL}/users/update/${currentUserId}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          Accept: 'application/json',
        },
        body: JSON.stringify(submitData),
      })

      const data = await response.json()

      if (response.ok && data.success) {
        const updatedUser = data.data?.user ||
          data.user || {
            id: currentUserId,
            nome: form.nome,
            email: form.email,
            telefone: form.telefone,
            foto_perfil: uploadedImageUrl,
            nivel_ingles: form.nivel_ingles,
            idioma_preferido: form.idioma_preferido,
            status: form.status,
            objetivos_aprendizado: form.objetivos_aprendizado,
          }

        localStorage.setItem('user', JSON.stringify(updatedUser))
        window.dispatchEvent(new CustomEvent('user-updated', { detail: updatedUser }))

        success(t('success.updated'))

        setTimeout(() => {
          router.push('/profile')
        }, 1500)
      } else {
        error(data.message || t('errors.serverError'))
      }
    } catch {
      error(t('errors.networkError'))
    } finally {
      loading.value = false
    }
  }

  onMounted(() => {
    loadUserData()
  })

  return {
    form,
    errors,
    loading,
    showPassword,
    showConfirmPassword,
    strengthClass,
    strengthText,
    strengthWidth,
    phoneError,
    passwordsMatch,
    imagePreview,
    selectedImage,
    handlePhoneInput,
    handlePhoneKeydown,
    checkPasswordStrength,
    handlePasswordInput,
    handleConfirmPasswordInput,
    handleImageChange,
    handleSubmit,
  }
}
