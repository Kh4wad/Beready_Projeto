<template>
  <div class="profile-container">
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
          <h1 class="profile-name">{{ user?.nome || 'Carregando...' }}</h1>
          <p class="profile-email">{{ user?.email || '' }}</p>
        </div>
        <div class="profile-actions">
          <button @click="$router.push('/profile/edit')" class="btn btn-edit">
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
                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
              />
            </svg>
            Editar Perfil
          </button>
          <button @click="$router.push('/dashboard')" class="btn btn-back">
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
            <div class="info-group">
              <label class="info-label">Nome Completo</label>
              <p class="info-value">{{ user?.nome || '-' }}</p>
            </div>
            <div class="info-group">
              <label class="info-label">E-mail</label>
              <p class="info-value">{{ user?.email || '-' }}</p>
            </div>
            <div class="info-group">
              <label class="info-label">Telefone</label>
              <p class="info-value">{{ user?.telefone || 'Não informado' }}</p>
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
            <div class="info-group">
              <label class="info-label">Nível de Inglês</label>
              <p class="info-value">{{ getNivelIngles(user?.nivel_ingles) }}</p>
            </div>
            <div class="info-group">
              <label class="info-label">Idioma Preferido</label>
              <p class="info-value">{{ getIdiomaPreferido(user?.idioma_preferido) }}</p>
            </div>
            <div class="info-group">
              <label class="info-label">Status</label>
              <p class="info-value">
                <span
                  class="status-badge"
                  :class="user?.status === 'ativo' ? 'status-active' : 'status-inactive'"
                >
                  {{ user?.status === 'ativo' ? 'Ativo' : 'Inativo' }}
                </span>
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Objetivos de Aprendizado -->
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
                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
              />
            </svg>
            Objetivos de Aprendizado
          </h3>
        </div>
        <div class="card-body">
          <p class="info-value objectives-text">
            {{ user?.objetivos_aprendizado || 'Nenhum objetivo definido' }}
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const user = ref<any>(null)

const getNivelIngles = (nivel: string) => {
  const niveis = {
    iniciante: 'Iniciante',
    intermediario: 'Intermediário',
    avancado: 'Avançado',
  }
  return niveis[nivel] || nivel || 'Não informado'
}

const getIdiomaPreferido = (idioma: string) => {
  const idiomas = {
    'pt-BR': 'Português (Brasil)',
    en: 'Inglês',
    es: 'Espanhol',
  }
  return idiomas[idioma] || idioma || 'Não informado'
}

onMounted(() => {
  const userData = localStorage.getItem('user')
  if (userData) {
    try {
      user.value = JSON.parse(userData)
    } catch (e) {
      console.error('Erro ao carregar usuário:', e)
    }
  }

  if (!user.value) {
    router.push('/login')
  }
})
</script>

<style scoped>
.profile-container {
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

.btn-edit {
  background: rgba(255, 255, 255, 0.2);
  color: white;
  border: 1px solid rgba(255, 255, 255, 0.3);
}

.btn-edit:hover {
  background: rgba(255, 255, 255, 0.3);
  transform: translateY(-2px);
}

.btn-back {
  background: rgba(0, 0, 0, 0.2);
  color: white;
  border: 1px solid rgba(255, 255, 255, 0.2);
}

.btn-back:hover {
  background: rgba(0, 0, 0, 0.3);
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

.info-group {
  margin-bottom: 1.5rem;
}

.info-group:last-child {
  margin-bottom: 0;
}

.info-label {
  display: block;
  font-size: 0.85rem;
  font-weight: 600;
  color: #6b7280;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  margin-bottom: 0.5rem;
}

.info-value {
  font-size: 1rem;
  color: #374151;
  margin: 0;
  padding: 0;
}

.objectives-text {
  line-height: 1.6;
}

.status-badge {
  display: inline-block;
  padding: 0.25rem 0.75rem;
  border-radius: 20px;
  font-size: 0.8rem;
  font-weight: 600;
}

.status-active {
  background: #d1fae5;
  color: #065f46;
}

.status-inactive {
  background: #fee2e2;
  color: #991b1b;
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
}
</style>
