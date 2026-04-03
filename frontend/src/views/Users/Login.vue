<template>
  <div class="main-content">
    <div class="login-container">
      <div class="login-header">
        <h1 class="login-title">Entrar</h1>
      </div>

      <div class="login-body">
        <!-- Flash Messages -->
        <div v-if="flashMessage" class="alert" :class="flashType">
          <i class="fas" :class="flashIcon"></i>
          {{ flashMessage }}
        </div>

        <!-- Login Form -->
        <form @submit.prevent="handleLogin" class="login-form">
          <div class="form-group">
            <label class="form-label">E-mail</label>
            <div class="input-wrapper">
              <input
                v-model="form.email"
                type="email"
                class="form-control"
                placeholder="seu.email@exemplo.com"
                required
                autofocus
              />
            </div>
            <div class="alternative-option">
              <a href="#" @click.prevent>Usar número do celular</a>
            </div>
          </div>

          <div class="form-group">
            <label class="form-label">Senha</label>
            <div class="input-wrapper password-wrapper">
              <input
                v-model="form.password"
                :type="showPassword ? 'text' : 'password'"
                class="form-control"
                placeholder="Sua senha"
                required
                id="password-input"
              />
              <i
                @click="showPassword = !showPassword"
                class="fas toggle-password"
                :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"
              ></i>
            </div>
            <div class="alternative-option">
              <a href="/forgot-password">Esqueceu sua senha?</a>
            </div>
          </div>

          <button type="submit" class="btn-login" :disabled="loading">
            {{ loading ? 'Entrando...' : 'Entrar' }}
          </button>
        </form>

        <div class="divider">
          <span class="divider-text">OU</span>
        </div>

        <div class="register-link">
          Não tem uma conta?
          <a href="/register">Registrar-se</a>
        </div>

        <div class="social-login">
          <button type="button" class="social-btn btn-google">
            <i class="fab fa-google social-icon"></i>
            Continuar com o Google
          </button>
          <button type="button" class="social-btn btn-apple">
            <i class="fab fa-apple social-icon"></i>
            Continuar com o Apple
          </button>
          <button type="button" class="social-btn btn-facebook">
            <i class="fab fa-facebook-f social-icon"></i>
            Continuar com o Facebook
          </button>
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
const showPassword = ref(false)
const flashMessage = ref('')
const flashType = ref('')
const flashIcon = ref('')

const form = ref({
  email: '',
  password: '',
})

const showFlash = (message: string, type: 'success' | 'error' | 'danger') => {
  flashMessage.value = message
  flashType.value = type === 'success' ? 'alert-success' : 'alert-error'
  flashIcon.value = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'

  setTimeout(() => {
    flashMessage.value = ''
  }, 5000)
}

const handleLogin = async () => {
  loading.value = true
  flashMessage.value = ''

  try {
    const response = await fetch('http://localhost:8765/auth/login', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(form.value),
    })

    const data = await response.json()

    if (data.success) {
      localStorage.setItem('user', JSON.stringify(data.user))
      router.push('/dashboard')
    } else {
      showFlash(data.message || 'E-mail ou senha inválidos.', 'error')
    }
  } catch (err) {
    console.error('Erro na requisição:', err)
    showFlash('Erro de conexão com o servidor', 'error')
  } finally {
    loading.value = false
  }
}
</script>

<style scoped>
.main-content {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  padding: 40px 20px;
  background-color: #f5f5f5;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.login-container {
  background: white;
  border-radius: 12px;
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
  width: 100%;
  max-width: 420px;
  overflow: hidden;
}

.login-header {
  background: #d81b60;
  color: white;
  padding: 25px 30px;
  text-align: center;
}

.login-title {
  font-size: 1.8rem;
  font-weight: 600;
  margin: 0;
}

.login-body {
  padding: 30px;
}

.form-group {
  margin-bottom: 20px;
  position: relative;
}

.form-label {
  display: block;
  margin-bottom: 8px;
  font-weight: 500;
  color: #343a40;
}

.input-wrapper {
  position: relative;
}

.form-control {
  width: 100%;
  padding: 12px 15px;
  border: 1px solid #dee2e6;
  border-radius: 6px;
  font-size: 16px;
  transition: all 0.3s;
  box-sizing: border-box;
}

.form-control:focus {
  border-color: #d81b60;
  box-shadow: 0 0 0 3px rgba(216, 27, 96, 0.1);
  outline: none;
}

.password-wrapper {
  position: relative;
}

.toggle-password {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  right: 15px;
  cursor: pointer;
  color: #6c757d;
  font-size: 16px;
}

.alternative-option {
  text-align: right;
  margin-top: 5px;
}

.alternative-option a {
  color: #d81b60;
  text-decoration: none;
  font-size: 14px;
}

.alternative-option a:hover {
  text-decoration: underline;
}

.btn-login {
  width: 100%;
  padding: 12px;
  background: #d81b60;
  color: white;
  border: none;
  border-radius: 6px;
  font-size: 16px;
  font-weight: 600;
  cursor: pointer;
  transition: background 0.3s;
  margin-top: 10px;
}

.btn-login:hover {
  background: #c2185b;
}

.btn-login:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.divider {
  display: flex;
  align-items: center;
  margin: 25px 0;
  color: #6c757d;
}

.divider::before,
.divider::after {
  content: '';
  flex: 1;
  border-bottom: 1px solid #dee2e6;
}

.divider-text {
  padding: 0 15px;
  font-size: 14px;
}

.register-link {
  text-align: center;
  margin-bottom: 25px;
}

.register-link a {
  color: #d81b60;
  text-decoration: none;
  font-weight: 500;
}

.register-link a:hover {
  text-decoration: underline;
}

.social-login {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.social-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  padding: 12px;
  border: 1px solid #dee2e6;
  border-radius: 6px;
  background: white;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.3s;
}

.social-btn:hover {
  background: #f8f9fa;
  border-color: #adb5bd;
}

.social-icon {
  font-size: 18px;
}

.btn-google {
  color: #db4437;
}

.btn-apple {
  color: #000;
}

.btn-facebook {
  color: #4267b2;
}

/* Alert Messages */
.alert {
  border-radius: 6px;
  padding: 12px 15px;
  margin-bottom: 20px;
  border: 1px solid transparent;
  display: flex;
  align-items: center;
  gap: 10px;
}

.alert-success {
  background-color: #d4edda;
  border-color: #c3e6cb;
  color: #155724;
}

.alert-error {
  background-color: #f8d7da;
  border-color: #f5c6cb;
  color: #721c24;
}

.alert i {
  font-size: 16px;
}
</style>
