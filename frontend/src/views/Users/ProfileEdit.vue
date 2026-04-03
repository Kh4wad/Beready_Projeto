<template>
  <div class="edit-profile-container">
    <!-- Header -->
    <div class="profile-header">
      <div class="header-background"></div>
      <div class="profile-content">
        <div class="profile-avatar">
          <div class="avatar-placeholder">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-8 w-8"
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
        </div>
        <div class="profile-info">
          <h1 class="profile-name">Editar Perfil</h1>
          <p class="profile-email">Atualize suas informações pessoais</p>
        </div>
        <div class="profile-actions">
          <button @click="$router.push('/profile')" class="btn btn-back">
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
            Voltar
          </button>
        </div>
      </div>
    </div>

    <div class="profile-body">
      <form @submit.prevent="handleSubmit" class="edit-profile-form">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <!-- Informações Pessoais -->
          <div class="card profile-card">
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
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                    />
                  </svg>
                  <input
                    v-model="form.nome"
                    type="text"
                    required
                    class="form-input"
                    placeholder="Seu nome completo"
                  />
                </div>
              </div>

              <div class="form-group">
                <label class="form-label">E-mail *</label>
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
              </div>

              <div class="form-group">
                <label class="form-label">Telefone</label>
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
                      d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                    />
                  </svg>
                  <input
                    v-model="form.telefone"
                    type="tel"
                    class="form-input telefone-input"
                    placeholder="(99) 99999-9999"
                    maxlength="15"
                    @input="formatTelefone"
                  />
                </div>
              </div>
            </div>
          </div>

          <!-- Preferências de Aprendizado -->
          <div class="card profile-card">
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
                <div class="input-container select-container">
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
                      d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"
                    />
                  </svg>
                  <select v-model="form.nivel_ingles" class="form-input select-input">
                    <option value="">Selecione seu nível</option>
                    <option value="iniciante">Iniciante</option>
                    <option value="intermediario">Intermediário</option>
                    <option value="avancado">Avançado</option>
                  </select>
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="select-arrow"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M19 9l-7 7-7-7"
                    />
                  </svg>
                </div>
              </div>

              <div class="form-group">
                <label class="form-label">Idioma Preferido</label>
                <div class="input-container select-container">
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
                      d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                  </svg>
                  <select v-model="form.idioma_preferido" class="form-input select-input">
                    <option value="">Selecione o idioma</option>
                    <option value="pt-BR">Português (Brasil)</option>
                    <option value="en">Inglês</option>
                    <option value="es">Espanhol</option>
                  </select>
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="select-arrow"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M19 9l-7 7-7-7"
                    />
                  </svg>
                </div>
              </div>

              <div class="form-group">
                <label class="form-label">Status</label>
                <div class="input-container select-container">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="input-icon"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" />
                  </svg>
                  <select v-model="form.status" class="form-input select-input">
                    <option value="ativo">Ativo</option>
                    <option value="inativo">Inativo</option>
                  </select>
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="select-arrow"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M19 9l-7 7-7-7"
                    />
                  </svg>
                </div>
              </div>

              <div class="form-group">
                <label class="form-label">Objetivos de Aprendizado</label>
                <div class="input-container textarea-container">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="input-icon textarea-icon"
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
                  <textarea
                    v-model="form.objetivos_aprendizado"
                    rows="4"
                    class="form-input textarea-input"
                    placeholder="Descreva seus objetivos de aprendizado..."
                  ></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Segurança -->
        <div class="card profile-card mt-6">
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
                  d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                />
              </svg>
              Alterar Senha
            </h3>
            <small class="text-muted">Deixe em branco para manter a senha atual</small>
          </div>
          <div class="card-body">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="form-group">
                <label class="form-label">Nova Senha</label>
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
                    v-model="form.nova_senha"
                    :type="showPassword ? 'text' : 'password'"
                    class="form-input password-input"
                    placeholder="Mínimo 6 caracteres"
                    @input="checkPasswordStrength"
                  />
                  <button
                    type="button"
                    @click="showPassword = !showPassword"
                    class="toggle-password"
                  >
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
                <label class="form-label">Confirmar Nova Senha</label>
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
                    class="form-input password-input"
                    placeholder="Digite a senha novamente"
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
          </div>
        </div>

        <!-- Form Actions -->
        <div class="form-actions">
          <button type="button" @click="$router.push('/profile')" class="btn btn-cancel">
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
                d="M6 18L18 6M6 6l12 12"
              />
            </svg>
            Cancelar
          </button>
          <button type="submit" :disabled="loading" class="btn btn-save">
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
                d="M5 13l4 4L19 7"
              />
            </svg>
            {{ loading ? 'Salvando...' : 'Salvar Alterações' }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const loading = ref(false)
const showPassword = ref(false)
const showConfirmPassword = ref(false)
const strengthClass = ref('')
const strengthText = ref('Força da senha')
const strengthWidth = ref('0%')

const form = ref({
  id: '',
  nome: '',
  email: '',
  telefone: '',
  nivel_ingles: '',
  idioma_preferido: '',
  status: 'ativo',
  objetivos_aprendizado: '',
  nova_senha: '',
  confirmar_senha: '',
})

const passwordsMatch = computed(() => {
  if (!form.value.nova_senha && !form.value.confirmar_senha) return true
  return form.value.nova_senha === form.value.confirmar_senha
})

const formatTelefone = (e: Event) => {
  const target = e.target as HTMLInputElement
  let value = target.value.replace(/\D/g, '')

  if (value.length <= 11) {
    if (value.length <= 2) {
      value = value.replace(/^(\d{0,2})/, '($1')
    } else if (value.length <= 7) {
      value = value.replace(/^(\d{2})(\d{0,5})/, '($1) $2')
    } else if (value.length <= 11) {
      value = value.replace(/^(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3')
    }
    target.value = value
    form.value.telefone = value
  }
}

const checkPasswordStrength = () => {
  const password = form.value.nova_senha
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

const loadUserData = () => {
  const userData = localStorage.getItem('user')
  if (userData) {
    try {
      const user = JSON.parse(userData)
      form.value.id = user.id || ''
      form.value.nome = user.nome || ''
      form.value.email = user.email || ''
      form.value.telefone = user.telefone || ''
      form.value.nivel_ingles = user.nivel_ingles || ''
      form.value.idioma_preferido = user.idioma_preferido || ''
      form.value.status = user.status || 'ativo'
      form.value.objetivos_aprendizado = user.objetivos_aprendizado || ''
    } catch (e) {
      console.error('Erro ao carregar usuário:', e)
    }
  }
}

const handleSubmit = async () => {
  // Validar senha se foi preenchida
  if (form.value.nova_senha || form.value.confirmar_senha) {
    if (form.value.nova_senha !== form.value.confirmar_senha) {
      alert('As senhas não coincidem')
      return
    }
    if (form.value.nova_senha.length < 6) {
      alert('A senha deve ter pelo menos 6 caracteres')
      return
    }
  }

  loading.value = true

  try {
    const submitData: any = {
      nome: form.value.nome,
      email: form.value.email,
      telefone: form.value.telefone,
      nivel_ingles: form.value.nivel_ingles,
      idioma_preferido: form.value.idioma_preferido,
      status: form.value.status,
      objetivos_aprendizado: form.value.objetivos_aprendizado,
    }

    if (form.value.nova_senha) {
      submitData.senha = form.value.nova_senha
    }

    const response = await fetch(`http://localhost:8765/users/${form.value.id}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(submitData),
    })

    const data = await response.json()

    if (data.success) {
      // Atualizar localStorage com novos dados
      localStorage.setItem('user', JSON.stringify(data.user))
      alert('Perfil atualizado com sucesso!')
      router.push('/profile')
    } else {
      alert(data.message || 'Erro ao atualizar perfil')
    }
  } catch (err) {
    console.error('Erro na requisição:', err)
    alert('Erro de conexão com o servidor')
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  loadUserData()
})
</script>

<style scoped>
.edit-profile-container {
  min-height: 100vh;
  background: #f8f9fa;
}

.profile-header {
  position: relative;
  background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
  color: white;
  padding: 2rem 0;
  margin-bottom: 2rem;
}

.header-background {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none"><path d="M1200 120L0 16.48 0 0 1200 0 1200 120z" fill="%23ffffff" fill-opacity="0.1"/></svg>')
    bottom center no-repeat;
  background-size: cover;
}

.profile-content {
  position: relative;
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 1rem;
  display: flex;
  align-items: center;
  gap: 2rem;
}

.profile-avatar {
  flex-shrink: 0;
}

.avatar-placeholder {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.2);
  display: flex;
  align-items: center;
  justify-content: center;
  border: 3px solid rgba(255, 255, 255, 0.3);
  backdrop-filter: blur(10px);
}

.avatar-placeholder svg {
  width: 2rem;
  height: 2rem;
  color: white;
}

.profile-info {
  flex: 1;
}

.profile-name {
  font-size: 2rem;
  font-weight: 700;
  margin: 0 0 0.5rem 0;
  color: white;
}

.profile-email {
  font-size: 1.1rem;
  opacity: 0.9;
  margin: 0;
}

.profile-actions {
  display: flex;
  gap: 0.5rem;
  flex-shrink: 0;
}

.btn {
  padding: 0.75rem 1.5rem;
  border: none;
  border-radius: 10px;
  font-weight: 600;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  transition: all 0.3s ease;
  cursor: pointer;
  font-size: 0.95rem;
}

.btn-back {
  background: rgba(255, 255, 255, 0.2);
  color: white;
  border: 1px solid rgba(255, 255, 255, 0.3);
}

.btn-back:hover {
  background: rgba(255, 255, 255, 0.3);
  transform: translateY(-2px);
}

.profile-body {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 1rem 2rem;
}

.profile-card {
  border: none;
  border-radius: 15px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
  transition:
    transform 0.3s ease,
    box-shadow 0.3s ease;
  background: white;
}

.profile-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
}

.card-header {
  background: white;
  border-bottom: 1px solid #e5e7eb;
  padding: 1.5rem;
  border-radius: 15px 15px 0 0;
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 0.5rem;
}

.card-title {
  font-size: 1.25rem;
  font-weight: 600;
  color: #374151;
  margin: 0;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.card-title svg {
  color: #7c3aed;
}

.card-body {
  padding: 1.5rem;
}

.text-muted {
  color: #6b7280;
  font-size: 0.875rem;
}

.form-group {
  margin-bottom: 1.5rem;
}

.form-label {
  display: block;
  font-weight: 600;
  color: #374151;
  margin-bottom: 0.5rem;
  font-size: 0.95rem;
}

.input-container {
  position: relative;
}

.input-icon {
  position: absolute;
  left: 1rem;
  top: 50%;
  transform: translateY(-50%);
  color: #6b7280;
  width: 1rem;
  height: 1rem;
  z-index: 2;
}

.textarea-icon {
  top: 1.25rem;
  transform: none;
}

.form-input {
  width: 100%;
  padding: 0.875rem 1rem 0.875rem 3rem;
  border: 2px solid #e5e7eb;
  border-radius: 10px;
  font-size: 1rem;
  transition: all 0.3s ease;
  background: white;
  color: #374151;
  font-family: inherit;
}

.select-input {
  appearance: none;
  cursor: pointer;
  padding-right: 3rem;
}

.textarea-input {
  padding: 1rem 1rem 1rem 3rem;
  min-height: 120px;
  resize: vertical;
  line-height: 1.5;
}

.select-arrow {
  position: absolute;
  right: 1rem;
  top: 50%;
  transform: translateY(-50%);
  color: #6b7280;
  width: 1rem;
  height: 1rem;
  pointer-events: none;
}

.form-input:focus {
  border-color: #7c3aed;
  box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
  outline: none;
}

.password-strength {
  margin-top: 0.5rem;
}

.strength-bar {
  height: 6px;
  background: #e5e7eb;
  border-radius: 3px;
  overflow: hidden;
  margin-bottom: 0.25rem;
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
  font-size: 0.8rem;
  color: #6b7280;
  font-weight: 500;
}

.password-match {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin-top: 0.5rem;
  font-size: 0.8rem;
  font-weight: 500;
}

.password-match.matching {
  color: #059669;
}

.password-match.not-matching {
  color: #dc2626;
}

.toggle-password {
  position: absolute;
  right: 1rem;
  top: 50%;
  transform: translateY(-50%);
  color: #6b7280;
  cursor: pointer;
  z-index: 2;
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

.form-actions {
  display: flex;
  gap: 1rem;
  justify-content: flex-end;
  padding: 1.5rem;
  background: white;
  border-radius: 15px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
  margin-top: 1.5rem;
}

.btn-cancel {
  background: #6b7280;
  color: white;
}

.btn-cancel:hover {
  background: #4b5563;
  transform: translateY(-2px);
}

.btn-save {
  background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
  color: white;
  border: none;
}

.btn-save:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(124, 58, 237, 0.3);
}

.btn-save:disabled {
  background: #9ca3af;
  cursor: not-allowed;
  transform: none;
  box-shadow: none;
}

.mt-6 {
  margin-top: 1.5rem;
}

/* Responsividade */
@media (max-width: 768px) {
  .profile-content {
    flex-direction: column;
    text-align: center;
    gap: 1rem;
  }

  .profile-actions {
    justify-content: center;
  }

  .profile-name {
    font-size: 1.75rem;
  }

  .avatar-placeholder {
    width: 70px;
    height: 70px;
  }

  .form-actions {
    flex-direction: column;
  }

  .btn {
    width: 100%;
    justify-content: center;
  }
}

@media (max-width: 480px) {
  .profile-header {
    padding: 1.5rem 0;
  }

  .profile-name {
    font-size: 1.5rem;
  }

  .card-body {
    padding: 1rem;
  }

  .form-input {
    padding: 0.75rem 0.875rem 0.75rem 2.5rem;
  }

  .textarea-input {
    padding: 0.75rem 0.875rem 0.75rem 2.5rem;
  }

  .input-icon {
    left: 0.875rem;
  }
}
</style>
