<template>
  <div class="reset-password-container">
    <div class="reset-password-card">
      <div class="card-header">
        <div class="header-icon">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-10 w-10"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"
            />
          </svg>
        </div>
        <h1 class="card-title">Redefinir Senha</h1>
        <p class="card-subtitle">Crie uma nova senha para sua conta</p>
      </div>

      <div class="card-body">
        <!-- Flash Message -->
        <div v-if="flashMessage" class="message" :class="flashType">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5 flex-shrink-0"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              v-if="flashType === 'success'"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
            />
            <path
              v-else
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
            />
          </svg>
          {{ flashMessage }}
        </div>

        <form @submit.prevent="handleSubmit" class="reset-password-form">
          <div class="form-section">
            <h3 class="section-title">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                />
              </svg>
              Nova Senha
            </h3>

            <div class="form-group">
              <label class="form-label">Nova Senha *</label>
              <div class="input-container password-container">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="input-icon"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"
                  />
                </svg>
                <input
                  v-model="form.senha"
                  :type="showPassword ? 'text' : 'password'"
                  required
                  class="form-input password-input"
                  placeholder="Digite sua nova senha"
                  @input="checkPasswordStrength"
                />
                <button type="button" @click="showPassword = !showPassword" class="toggle-password">
                  <svg
                    v-if="!showPassword"
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                    />
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                    />
                  </svg>
                  <svg
                    v-else
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"
                    />
                  </svg>
                </button>
              </div>
              <div class="password-strength">
                <div class="strength-bar">
                  <div
                    class="strength-fill"
                    :class="strengthClass"
                    :style="{ width: strengthWidth }"
                  ></div>
                </div>
                <div class="strength-text">{{ strengthText }}</div>
              </div>
            </div>

            <div class="form-group">
              <label class="form-label">Confirmar Nova Senha *</label>
              <div class="input-container password-container">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="input-icon"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"
                  />
                </svg>
                <input
                  v-model="form.confirmar_senha"
                  :type="showConfirmPassword ? 'text' : 'password'"
                  required
                  class="form-input password-input"
                  placeholder="Digite a nova senha novamente"
                  @input="checkPasswordMatch"
                />
                <button
                  type="button"
                  @click="showConfirmPassword = !showConfirmPassword"
                  class="toggle-password"
                >
                  <svg
                    v-if="!showConfirmPassword"
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                    />
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                    />
                  </svg>
                  <svg
                    v-else
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"
                    />
                  </svg>
                </button>
              </div>
              <div
                v-if="form.confirmar_senha"
                class="password-match"
                :class="{ matching: passwordsMatch, 'not-matching': !passwordsMatch }"
              >
                <svg
                  v-if="passwordsMatch"
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-4 w-4"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                  />
                </svg>
                <svg
                  v-else
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-4 w-4"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"
                  />
                </svg>
                <span>{{
                  passwordsMatch ? 'As senhas coincidem' : 'As senhas não coincidem'
                }}</span>
              </div>
            </div>
          </div>

          <div class="form-actions">
            <button type="button" @click="$router.push('/login')" class="btn btn-secondary">
              Cancelar
            </button>
            <button
              type="submit"
              :disabled="loading || !passwordsMatch || form.senha.length < 6"
              class="btn btn-primary"
            >
              {{ loading ? 'Redefinindo...' : 'Redefinir Senha' }}
            </button>
          </div>
        </form>

        <div class="login-redirect">
          <p>
            Lembrou sua senha?
            <a href="/login" class="login-link">Fazer Login</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'

const router = useRouter()
const route = useRoute()
const loading = ref(false)
const showPassword = ref(false)
const showConfirmPassword = ref(false)
const flashMessage = ref('')
const flashType = ref('')
const strengthClass = ref('')
const strengthText = ref('Força da senha')
const strengthWidth = ref('0%')

const form = ref({
  senha: '',
  confirmar_senha: '',
  token: '',
})

const passwordsMatch = computed(() => {
  return (
    form.value.senha &&
    form.value.confirmar_senha &&
    form.value.senha === form.value.confirmar_senha
  )
})

const checkPasswordStrength = () => {
  const password = form.value.senha
  let strength = 0

  if (password.length >= 8) strength++
  if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++
  if (password.match(/\d/)) strength++
  if (password.match(/[^a-zA-Z\d]/)) strength++

  switch (strength) {
    case 0:
      strengthText.value = 'Força da senha: Muito Fraca'
      strengthClass.value = ''
      strengthWidth.value = '0%'
      break
    case 1:
      strengthText.value = 'Força da senha: Fraca'
      strengthClass.value = 'weak'
      strengthWidth.value = '25%'
      break
    case 2:
      strengthText.value = 'Força da senha: Moderada'
      strengthClass.value = 'medium'
      strengthWidth.value = '50%'
      break
    case 3:
      strengthText.value = 'Força da senha: Forte'
      strengthClass.value = 'strong'
      strengthWidth.value = '75%'
      break
    case 4:
      strengthText.value = 'Força da senha: Muito Forte'
      strengthClass.value = 'very-strong'
      strengthWidth.value = '100%'
      break
  }
}

const checkPasswordMatch = () => {
  // Força reatividade
}

const handleSubmit = async () => {
  if (!passwordsMatch.value) {
    flashType.value = 'error'
    flashMessage.value = 'As senhas não coincidem'
    return
  }

  if (form.value.senha.length < 6) {
    flashType.value = 'error'
    flashMessage.value = 'A senha deve ter pelo menos 6 caracteres'
    return
  }

  loading.value = true
  flashMessage.value = ''

  try {
    const response = await fetch(`http://localhost:8765/auth/reset-password/${form.value.token}`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ senha: form.value.senha }),
    })

    const data = await response.json()

    if (data.success) {
      flashType.value = 'success'
      flashMessage.value = 'Senha redefinida com sucesso! Redirecionando...'
      setTimeout(() => {
        router.push('/login')
      }, 3000)
    } else {
      flashType.value = 'error'
      flashMessage.value = data.message || 'Erro ao redefinir senha'
    }
  } catch (err) {
    console.error('Erro:', err)
    flashType.value = 'error'
    flashMessage.value = 'Erro de conexão com o servidor'
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  form.value.token = (route.params.token as string) || (route.query.token as string)
  if (!form.value.token) {
    flashType.value = 'error'
    flashMessage.value = 'Token inválido ou expirado'
  }
})
</script>

<style scoped>
.reset-password-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 80vh;
  padding: 20px;
  background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
}

.reset-password-card {
  background: white;
  border-radius: 20px;
  box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
  width: 100%;
  max-width: 500px;
  overflow: hidden;
}

.card-header {
  background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
  color: white;
  padding: 40px 32px;
  text-align: center;
  position: relative;
}

.card-header::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 4px;
  background: linear-gradient(90deg, #8b5cf6, #a78bfa);
}

.header-icon {
  width: 80px;
  height: 80px;
  background: rgba(255, 255, 255, 0.2);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 20px;
  backdrop-filter: blur(10px);
  border: 2px solid rgba(255, 255, 255, 0.3);
}

.card-title {
  font-size: 28px;
  font-weight: 700;
  margin: 0 0 8px 0;
  color: white;
}

.card-subtitle {
  font-size: 16px;
  opacity: 0.9;
  margin: 0;
}

.card-body {
  padding: 40px;
}

.form-section {
  background: #f8fafc;
  padding: 25px;
  border-radius: 12px;
  border: 1px solid #e2e8f0;
  margin-bottom: 20px;
}

.section-title {
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 18px;
  font-weight: 600;
  color: #374151;
  margin-bottom: 20px;
  padding-bottom: 12px;
  border-bottom: 2px solid #e5e7eb;
}

.section-title svg {
  color: #7c3aed;
}

.form-group {
  margin-bottom: 20px;
}

.form-label {
  display: block;
  font-size: 14px;
  font-weight: 600;
  color: #374151;
  margin-bottom: 8px;
}

.input-container {
  position: relative;
}

.password-container {
  position: relative;
}

.input-icon {
  position: absolute;
  left: 16px;
  top: 50%;
  transform: translateY(-50%);
  color: #6b7280;
  width: 18px;
  height: 18px;
  z-index: 2;
}

.form-input {
  width: 100%;
  padding: 14px 16px 14px 50px;
  border: 2px solid #e5e7eb;
  border-radius: 10px;
  font-size: 16px;
  transition: all 0.3s ease;
  background: white;
  color: #374151;
}

.password-input {
  padding-right: 50px !important;
}

.form-input:focus {
  border-color: #7c3aed;
  box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
  outline: none;
  transform: translateY(-1px);
}

.toggle-password {
  position: absolute;
  right: 16px;
  top: 50%;
  transform: translateY(-50%);
  color: #6b7280;
  cursor: pointer;
  background: none;
  border: none;
  padding: 0;
  display: flex;
  align-items: center;
  justify-content: center;
}

.toggle-password:hover {
  color: #374151;
}

.password-strength {
  margin-top: 8px;
}

.strength-bar {
  height: 6px;
  background: #e5e7eb;
  border-radius: 3px;
  overflow: hidden;
  margin-bottom: 6px;
}

.strength-fill {
  height: 100%;
  background: #ef4444;
  transition: all 0.3s ease;
  border-radius: 3px;
}

.strength-fill.weak {
  background: #ef4444;
}
.strength-fill.medium {
  background: #f59e0b;
}
.strength-fill.strong {
  background: #10b981;
}
.strength-fill.very-strong {
  background: #059669;
}

.strength-text {
  font-size: 12px;
  color: #6b7280;
  font-weight: 500;
}

.password-match {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-top: 8px;
  font-size: 12px;
  font-weight: 500;
}

.password-match.matching {
  color: #059669;
}

.password-match.not-matching {
  color: #dc2626;
}

.form-actions {
  display: flex;
  gap: 15px;
  justify-content: flex-end;
  margin-top: 30px;
  padding-top: 20px;
  border-top: 1px solid #e5e7eb;
}

.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 14px 28px;
  border: none;
  border-radius: 10px;
  font-size: 16px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  min-width: 140px;
}

.btn-primary {
  background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
  color: white;
}

.btn-primary:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(124, 58, 237, 0.3);
}

.btn-primary:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.btn-secondary {
  background: white;
  color: #374151;
  border: 2px solid #d1d5db;
}

.btn-secondary:hover {
  border-color: #9ca3af;
  transform: translateY(-2px);
}

.login-redirect {
  text-align: center;
  margin-top: 30px;
  padding-top: 20px;
  border-top: 1px solid #e5e7eb;
  color: #6b7280;
}

.login-link {
  color: #7c3aed;
  text-decoration: none;
  font-weight: 600;
}

.login-link:hover {
  text-decoration: underline;
}

.message {
  padding: 16px;
  border-radius: 12px;
  margin-bottom: 24px;
  border-left: 4px solid;
  display: flex;
  align-items: flex-start;
  gap: 12px;
  font-size: 14px;
}

.message.success {
  background: #f0fdf4;
  border-left-color: #10b981;
  color: #065f46;
}

.message.error {
  background: #fef2f2;
  border-left-color: #ef4444;
  color: #991b1b;
}

@media (max-width: 480px) {
  .card-body {
    padding: 24px;
  }
  .card-header {
    padding: 30px 24px;
  }
  .header-icon {
    width: 60px;
    height: 60px;
  }
  .card-title {
    font-size: 24px;
  }
  .form-actions {
    flex-direction: column;
  }
  .btn {
    width: 100%;
  }
}
</style>
