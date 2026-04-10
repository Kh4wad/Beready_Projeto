<template>
  <div class="profile-edit-page">
    <div class="profile-edit-hero">
      <button class="hero-back-btn" @click="$router.push('/profile')">
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
            d="M10 19l-7-7m0 0l7-7m-7 7h18"
          />
        </svg>
        Voltar
      </button>
      <div class="hero-content">
        <div class="hero-icon">
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
              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
            />
          </svg>
        </div>
        <h1 class="hero-title">Editar Perfil</h1>
        <p class="hero-subtitle">Atualize suas informações pessoais</p>
      </div>
    </div>

    <div class="profile-edit-container">
      <form @submit.prevent="handleSubmit" class="profile-edit-form">
        <div class="form-grid">
          <div class="form-card">
            <div class="card-header">
              <h3 class="card-title">
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
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                  />
                </svg>
                Informações Pessoais
              </h3>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label class="form-label">Nome Completo *</label>
                <input
                  v-model="form.nome"
                  type="text"
                  class="form-input"
                  placeholder="Seu nome completo"
                  required
                />
              </div>
              <div class="form-group">
                <label class="form-label">E-mail *</label>
                <input
                  v-model="form.email"
                  type="email"
                  class="form-input"
                  placeholder="seu.email@exemplo.com"
                  required
                />
              </div>
              <div class="form-group">
                <label class="form-label">Telefone</label>
                <input
                  v-model="form.telefone"
                  type="tel"
                  class="form-input"
                  placeholder="(99)99999-9999"
                />
              </div>
            </div>
          </div>

          <div class="form-card">
            <div class="card-header">
              <h3 class="card-title">
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
                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                  />
                </svg>
                Preferências de Aprendizado
              </h3>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label class="form-label">Nível de Inglês</label>
                <select v-model="form.nivel_ingles" class="form-select">
                  <option value="">Selecione seu nível</option>
                  <option value="iniciante">Iniciante</option>
                  <option value="intermediario">Intermediário</option>
                  <option value="avancado">Avançado</option>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">Idioma Preferido</label>
                <select v-model="form.idioma_preferido" class="form-select">
                  <option value="">Selecione o idioma</option>
                  <option value="pt-BR">Português (Brasil)</option>
                  <option value="en">Inglês</option>
                  <option value="es">Espanhol</option>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">Objetivos de Aprendizado</label>
                <textarea
                  v-model="form.objetivos_aprendizado"
                  rows="3"
                  class="form-textarea"
                  placeholder="Descreva seus objetivos..."
                ></textarea>
              </div>
            </div>
          </div>

          <div class="form-card full-width">
            <div class="card-header">
              <div>
                <h3 class="card-title">
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
                  Alterar Senha
                </h3>
                <small class="form-hint">Deixe em branco para manter a senha atual</small>
              </div>
            </div>
            <div class="card-body">
              <div class="form-row">
                <div class="form-group">
                  <label class="form-label">Nova Senha</label>
                  <div class="password-wrapper">
                    <input
                      v-model="form.nova_senha"
                      :type="showPassword ? 'text' : 'password'"
                      class="form-input"
                      placeholder="Mínimo 6 caracteres"
                    />
                    <button
                      type="button"
                      class="password-toggle"
                      @click="showPassword = !showPassword"
                    >
                      <svg
                        v-if="!showPassword"
                        xmlns="http://www.w3.org/2000/svg"
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
                </div>
                <div class="form-group">
                  <label class="form-label">Confirmar Nova Senha</label>
                  <div class="password-wrapper">
                    <input
                      v-model="form.confirmar_senha"
                      :type="showConfirmPassword ? 'text' : 'password'"
                      class="form-input"
                      placeholder="Digite a senha novamente"
                    />
                    <button
                      type="button"
                      class="password-toggle"
                      @click="showConfirmPassword = !showConfirmPassword"
                    >
                      <svg
                        v-if="!showConfirmPassword"
                        xmlns="http://www.w3.org/2000/svg"
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
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="form-actions">
          <button type="button" class="btn-cancel" @click="$router.push('/profile')">
            Cancelar
          </button>
          <button type="submit" class="btn-save" :disabled="loading">
            {{ loading ? 'Salvando...' : 'Salvar Alterações' }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, reactive, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useAlert } from '@/shared/composables/useAlert'

const router = useRouter()
const { success, error } = useAlert()
const loading = ref(false)
const showPassword = ref(false)
const showConfirmPassword = ref(false)

const form = reactive({
  nome: '',
  email: '',
  telefone: '',
  nivel_ingles: '',
  idioma_preferido: '',
  objetivos_aprendizado: '',
  nova_senha: '',
  confirmar_senha: '',
})

const loadUserData = async () => {
  const userData = localStorage.getItem('user')
  if (!userData) {
    router.push('/login')
    return
  }

  const user = JSON.parse(userData)
  form.nome = user.nome || ''
  form.email = user.email || ''
  form.telefone = user.telefone || ''
  form.nivel_ingles = user.nivel_ingles || ''
  form.idioma_preferido = user.idioma_preferido || ''
  form.objetivos_aprendizado = user.objetivos_aprendizado || ''
}

const handleSubmit = async () => {
  const userData = localStorage.getItem('user')
  if (!userData) return

  const user = JSON.parse(userData)

  if (form.nova_senha && form.nova_senha !== form.confirmar_senha) {
    error('As senhas não coincidem')
    return
  }

  if (form.nova_senha && form.nova_senha.length < 6) {
    error('A senha deve ter pelo menos 6 caracteres')
    return
  }

  loading.value = true

  try {
    const submitData: any = {
      nome: form.nome,
      email: form.email,
      telefone: form.telefone,
      nivel_ingles: form.nivel_ingles,
      idioma_preferido: form.idioma_preferido,
      objetivos_aprendizado: form.objetivos_aprendizado,
    }

    if (form.nova_senha) {
      submitData.senha = form.nova_senha
    }

    const response = await fetch(`http://localhost:8765/users/update/${user.id}`, {
      method: 'PUT',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(submitData),
    })

    const data = await response.json()

    if (response.ok && data.success) {
      const updatedUser = { ...user, ...submitData }
      localStorage.setItem('user', JSON.stringify(updatedUser))
      success('Perfil atualizado com sucesso!')
      setTimeout(() => router.push('/profile'), 1500)
    } else {
      error(data.message || 'Erro ao atualizar perfil')
    }
  } catch (err) {
    error('Erro de conexão com o servidor')
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  loadUserData()
})
</script>

<style scoped>
@import '@/styles/views/users/profile-edit.css';
</style>
