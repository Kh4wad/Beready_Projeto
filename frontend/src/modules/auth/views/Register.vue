<template>
  <div class="register-page">
    <div class="register-container">
      <div class="register-card">
        <div class="register-header">
          <h1 class="register-title">{{ $t('register.title') }}</h1>
          <p class="register-subtitle">{{ $t('register.subtitle') }}</p>
        </div>

        <form @submit.prevent="handleSubmit">
          <div class="register-form-grid">
            <!-- Seção 1: Informações Pessoais -->
            <div class="register-section">
              <h2 class="register-section-title">{{ $t('register.personalInfo') }}</h2>
              <Input
                v-model="form.nome"
                :label="$t('register.nome')"
                :placeholder="$t('register.nomePlaceholder')"
                required
                :error="errors.nome"
              />
              <Input
                v-model="form.email"
                :label="$t('login.email')"
                type="email"
                :placeholder="$t('register.emailPlaceholder')"
                required
                :error="errors.email"
              />
              <Input
                v-model="form.telefone"
                :label="$t('profile.telefone')"
                type="tel"
                :placeholder="$t('register.telefonePlaceholder')"
                :error="phoneError"
                @input="handlePhoneInput"
                @keydown="handlePhoneKeydown"
              />
            </div>

            <!-- Seção 2: Segurança -->
            <div class="register-section">
              <h2 class="register-section-title">{{ $t('register.security') }}</h2>
              <Input
                v-model="form.senha"
                :label="$t('register.senha')"
                type="password"
                :placeholder="$t('register.senhaPlaceholder')"
                required
                :error="errors.senha"
                @input="checkPasswordStrength"
              />
              <div v-if="form.senha" class="register-password-strength">
                <div class="register-strength-bar">
                  <div
                    class="register-strength-fill"
                    :class="strengthClass"
                    :style="{ width: strengthWidth }"
                  ></div>
                </div>
                <span class="register-strength-text">{{ strengthText }}</span>
              </div>
              <Input
                v-model="form.confirmar_senha"
                :label="$t('register.confirmarSenha')"
                type="password"
                :placeholder="$t('register.confirmarSenhaPlaceholder')"
                required
                :error="errors.confirmar_senha"
                @input="checkPasswordMatch"
              />
              <div
                v-if="form.confirmar_senha"
                class="register-password-match"
                :class="{ matching: passwordsMatch, 'not-matching': !passwordsMatch }"
              >
                <span>{{
                  passwordsMatch
                    ? $t('register.passwordsMatch')
                    : $t('register.passwordsDoNotMatch')
                }}</span>
              </div>
            </div>

            <!-- Seção 3: Preferências -->
            <div class="register-section">
              <h2 class="register-section-title">{{ $t('register.learningPreferences') }}</h2>
              <Select
                v-model="form.nivel_ingles"
                :label="$t('profile.nivelIngles')"
                :placeholder="$t('register.selectLevel')"
                :options="nivelOptions"
              />
              <Select
                v-model="form.idioma_preferido"
                :label="$t('profile.idiomaPreferido')"
                :placeholder="$t('register.selectLanguage')"
                :options="idiomaOptions"
              />
              <Textarea
                v-model="form.objetivos_aprendizado"
                :label="$t('profile.objetivos')"
                :placeholder="$t('register.objetivosPlaceholder')"
                :rows="3"
              />
            </div>
          </div>

          <div class="register-form-actions">
            <Button variant="secondary" type="button" @click="$router.push('/login')">
              {{ $t('common.cancelar') }}
            </Button>
            <Button type="submit" :loading="loading">
              {{ $t('register.createAccount') }}
            </Button>
          </div>
        </form>

        <div class="register-login-redirect">
          <p>
            {{ $t('register.jaTemConta') }}
            <router-link to="/login">{{ $t('register.loginLink') }}</router-link>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { reactive, ref } from 'vue'
import Input from '@/shared/components/common/Input.vue'
import Select from '@/shared/components/common/Select.vue'
import Textarea from '@/shared/components/common/Textarea.vue'
import Button from '@/shared/components/common/Button.vue'
import { useAuthStore } from '@/stores/auth'
import { useAlert } from '@/shared/composables/useAlert'
import { useI18n } from 'vue-i18n'

const authStore = useAuthStore()
const { showAlert } = useAlert()
const { t } = useI18n()

const form = reactive({
  nome: '',
  email: '',
  telefone: '',
  senha: '',
  confirmar_senha: '',
  nivel_ingles: '',
  idioma_preferido: '',
  objetivos_aprendizado: '',
})

const errors = reactive({
  nome: '',
  email: '',
  senha: '',
  confirmar_senha: '',
})

const phoneError = ref('')
const loading = ref(false)
const passwordsMatch = ref(true)

// Opções para selects com tradução
const nivelOptions = [
  { value: 'iniciante', label: t('common.iniciante') },
  { value: 'intermediario', label: t('common.intermediario') },
  { value: 'avancado', label: t('common.avancado') },
]
const idiomaOptions = [
  { value: 'pt-BR', label: t('idiomas.pt') },
  { value: 'en', label: t('idiomas.en') },
  { value: 'es', label: t('idiomas.es') },
]

// Validações
const validateForm = () => {
  let valid = true
  if (!form.nome.trim()) {
    errors.nome = t('register.nomeRequired')
    valid = false
  } else errors.nome = ''

  if (!form.email.trim()) {
    errors.email = t('register.emailRequired')
    valid = false
  } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email)) {
    errors.email = t('register.emailInvalid')
    valid = false
  } else errors.email = ''

  if (!form.senha) {
    errors.senha = t('register.passwordRequired')
    valid = false
  } else if (form.senha.length < 6) {
    errors.senha = t('passwordValidation.minLength')
    valid = false
  } else errors.senha = ''

  if (form.senha !== form.confirmar_senha) {
    errors.confirmar_senha = t('passwordValidation.doNotMatch')
    valid = false
  } else errors.confirmar_senha = ''

  return valid
}

const formatPhone = (e: Event) => {
  let value = (e.target as HTMLInputElement).value.replace(/\D/g, '')
  if (value.length > 11) value = value.slice(0, 11)
  if (value.length > 10) {
    form.telefone = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3')
  } else if (value.length > 6) {
    form.telefone = value.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3')
  } else if (value.length > 2) {
    form.telefone = value.replace(/(\d{2})(\d{0,5})/, '($1) $2')
  } else {
    form.telefone = value
  }
  phoneError.value =
    form.telefone.length > 0 && form.telefone.length < 14 ? t('register.phoneIncomplete') : ''
}

// Força da senha
const strengthClass = ref('')
const strengthText = ref('')
const strengthWidth = ref('0%')
const checkPasswordStrength = () => {
  const pass = form.senha
  let strength = 0
  if (pass.length >= 6) strength++
  if (pass.match(/[a-z]/) && pass.match(/[A-Z]/)) strength++
  if (pass.match(/\d/)) strength++
  if (pass.match(/[^a-zA-Z0-9]/)) strength++
  if (strength === 0) {
    strengthClass.value = ''
    strengthText.value = ''
    strengthWidth.value = '0%'
  } else if (strength <= 2) {
    strengthClass.value = 'weak'
    strengthText.value = t('passwordStrength.weak')
    strengthWidth.value = '33%'
  } else if (strength === 3) {
    strengthClass.value = 'medium'
    strengthText.value = t('passwordStrength.medium')
    strengthWidth.value = '66%'
  } else {
    strengthClass.value = 'strong'
    strengthText.value = t('passwordStrength.strong')
    strengthWidth.value = '100%'
  }
}

const checkPasswordMatch = () => {
  passwordsMatch.value = form.senha === form.confirmar_senha
  if (!passwordsMatch.value) errors.confirmar_senha = t('passwordValidation.doNotMatch')
  else errors.confirmar_senha = ''
}

const handleSubmit = async () => {
  if (!validateForm()) return
  loading.value = true
  try {
    const response = await authStore.register(form)
    if (response.success) {
      showAlert(t('register.success'), 'success')
      setTimeout(() => (window.location.href = '/login'), 2000)
    } else {
      showAlert(response.message || t('register.error'), 'error')
    }
  } catch (err: any) {
    showAlert(err.message || t('errors.networkError'), 'error')
  } finally {
    loading.value = false
  }
}
</script>

<style scoped>
@import '@/styles/views/users/register.css';
</style>
