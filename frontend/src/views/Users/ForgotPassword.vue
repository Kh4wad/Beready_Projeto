<template>
  <div class="forgot-password-container">
    <div class="forgot-password-card">
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
        <h1 class="card-title">Recuperar Senha</h1>
        <p class="card-subtitle">Digite seu e-mail para receber o link de recuperação</p>
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

        <form @submit.prevent="handleSubmit" class="forgot-password-form">
          <div class="form-group">
            <div class="input-container">
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
                  d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                />
              </svg>
              <input
                v-model="form.email"
                type="email"
                required
                class="form-input"
                placeholder="seu.email@exemplo.com"
              />
            </div>
            <div class="input-help">
              <svg
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
                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                />
              </svg>
              Enviaremos um link seguro para redefinir sua senha
            </div>
          </div>

          <button type="submit" :disabled="loading" class="submit-btn">
            {{ loading ? 'Enviando...' : 'Enviar Link de Recuperação' }}
          </button>
        </form>

        <div class="back-link-container">
          <svg
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
              d="M10 19l-7-7m0 0l7-7m-7 7h18"
            />
          </svg>
          <a href="/login" class="back-link">Voltar para Login</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const loading = ref(false)
const flashMessage = ref('')
const flashType = ref('')

const form = ref({
  email: '',
})

const handleSubmit = async () => {
  loading.value = true
  flashMessage.value = ''

  try {
    const response = await fetch('http://localhost:8765/auth/forgot-password', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(form.value),
    })

    const data = await response.json()

    if (data.success) {
      flashType.value = 'success'
      flashMessage.value = data.message || 'Link de recuperação enviado para seu e-mail!'
      setTimeout(() => {
        router.push('/login')
      }, 3000)
    } else {
      flashType.value = 'error'
      flashMessage.value = data.message || 'Erro ao enviar link de recuperação'
    }
  } catch (err) {
    console.error('Erro:', err)
    flashType.value = 'error'
    flashMessage.value = 'Erro de conexão com o servidor'
  } finally {
    loading.value = false
  }
}
</script>

<style scoped>
.forgot-password-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 80vh;
  padding: 20px;
  background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
}

.forgot-password-card {
  background: white;
  border-radius: 20px;
  box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
  width: 100%;
  max-width: 450px;
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

.form-group {
  margin-bottom: 30px;
}

.input-container {
  position: relative;
  margin-bottom: 12px;
}

.input-icon {
  position: absolute;
  left: 16px;
  top: 50%;
  transform: translateY(-50%);
  color: #6b7280;
  width: 20px;
  height: 20px;
  z-index: 2;
}

.form-input {
  width: 100%;
  padding: 16px 16px 16px 50px;
  border: 2px solid #e5e7eb;
  border-radius: 12px;
  font-size: 16px;
  transition: all 0.3s ease;
  background: #f9fafb;
  color: #374151;
}

.form-input:focus {
  border-color: #7c3aed;
  background: white;
  box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
  outline: none;
  transform: translateY(-1px);
}

.input-help {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 14px;
  color: #6b7280;
  background: #f3f4f6;
  padding: 12px 16px;
  border-radius: 8px;
  border-left: 4px solid #7c3aed;
}

.input-help svg {
  color: #7c3aed;
}

.submit-btn {
  width: 100%;
  padding: 16px;
  background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
  color: white;
  border: none;
  border-radius: 12px;
  font-size: 16px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
}

.submit-btn:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(124, 58, 237, 0.3);
}

.submit-btn:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}

.back-link-container {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 12px;
  margin-top: 30px;
  padding-top: 20px;
  border-top: 1px solid #e5e7eb;
}

.back-link-container svg {
  color: #7c3aed;
}

.back-link {
  color: #7c3aed;
  text-decoration: none;
  font-weight: 500;
  transition: all 0.3s ease;
  padding: 8px 16px;
  border-radius: 8px;
}

.back-link:hover {
  color: #6d28d9;
  background: #faf5ff;
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
}
</style>
