import { ref, computed } from 'vue'
import { useI18n } from 'vue-i18n'

export function usePasswordValidation() {
  const { t } = useI18n()
  const password = ref('')
  const confirmPassword = ref('')
  const passwordError = ref('')
  const confirmPasswordError = ref('')

  const validatePassword = (value: string): string | null => {
    if (!value) return null
    if (value.length < 6) {
      return t('passwordValidation.minLength')
    }
    return null
  }

  const validateConfirmPassword = (value: string): string | null => {
    if (!value) return null
    if (password.value !== value) {
      return t('passwordValidation.doNotMatch')
    }
    return null
  }

  const checkPasswordStrength = (value: string) => {
    let score = 0
    if (value.length >= 8) score++
    if (value.match(/[a-z]/) && value.match(/[A-Z]/)) score++
    if (value.match(/\d/)) score++
    if (value.match(/[^a-zA-Z\d]/)) score++

    const strengthMap = {
      0: {
        text: t('passwordStrength.veryWeak'),
        class: '',
        width: '0%',
      },
      1: {
        text: t('passwordStrength.weak'),
        class: 'weak',
        width: '25%',
      },
      2: {
        text: t('passwordStrength.medium'),
        class: 'medium',
        width: '50%',
      },
      3: {
        text: t('passwordStrength.strong'),
        class: 'strong',
        width: '75%',
      },
      4: {
        text: t('passwordStrength.veryStrong'),
        class: 'very-strong',
        width: '100%',
      },
    }

    return strengthMap[score as keyof typeof strengthMap]
  }

  const isPasswordValid = computed(() => {
    if (!password.value) return true
    return password.value.length >= 6
  })

  const isConfirmPasswordValid = computed(() => {
    if (!confirmPassword.value) return true
    return password.value === confirmPassword.value
  })

  const passwordsMatch = computed(() => {
    if (!password.value || !confirmPassword.value) return true
    return password.value === confirmPassword.value
  })

  const handlePasswordInput = (value: string) => {
    password.value = value
    passwordError.value = validatePassword(value) || ''
    if (confirmPassword.value) {
      confirmPasswordError.value = validateConfirmPassword(confirmPassword.value) || ''
    }
  }

  const handleConfirmPasswordInput = (value: string) => {
    confirmPassword.value = value
    confirmPasswordError.value = validateConfirmPassword(value) || ''
  }

  const resetPasswords = () => {
    password.value = ''
    confirmPassword.value = ''
    passwordError.value = ''
    confirmPasswordError.value = ''
  }

  return {
    password,
    confirmPassword,
    passwordError,
    confirmPasswordError,
    isPasswordValid,
    isConfirmPasswordValid,
    passwordsMatch,
    validatePassword,
    validateConfirmPassword,
    checkPasswordStrength,
    handlePasswordInput,
    handleConfirmPasswordInput,
    resetPasswords,
  }
}
