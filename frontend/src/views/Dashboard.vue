<template>
  <div class="dashboard-container">
    <!-- Sidebar / Navbar Moderno -->
    <nav class="dashboard-nav">
      <div class="nav-container">
        <div class="nav-brand">
          <div class="logo-icon">
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
                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
              />
            </svg>
          </div>
          <h1 class="nav-title">Beready</h1>
        </div>

        <div class="nav-menu">
          <router-link to="/dashboard" class="nav-link active">
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
                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
              />
            </svg>
            Dashboard
          </router-link>
          <router-link to="/profile" class="nav-link">
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
            Perfil
          </router-link>
          <router-link to="/flashcards" class="nav-link">
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
                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
              />
            </svg>
            Flashcards
          </router-link>
          <router-link to="/quizes" class="nav-link">
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
                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
              />
            </svg>
            Quizes
          </router-link>
          <router-link to="/prompts" class="nav-link">
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
                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"
              />
            </svg>
            Prompts IA
          </router-link>
        </div>

        <div class="nav-user">
          <div class="user-info">
            <div class="user-avatar">
              {{ user?.nome?.charAt(0) || user?.name?.charAt(0) || 'U' }}
            </div>
            <div class="user-details">
              <span class="user-name">{{ user?.nome || user?.name || 'Usuário' }}</span>
              <span class="user-email">{{ user?.email || '' }}</span>
            </div>
          </div>
          <button @click="handleLogout" :disabled="loading" class="logout-btn">
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
                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
              />
            </svg>
            {{ loading ? 'Saindo...' : 'Sair' }}
          </button>
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <main class="dashboard-main">
      <!-- Welcome Section -->
      <div class="welcome-section">
        <h1 class="welcome-title">
          Bem-vindo de volta, {{ user?.nome?.split(' ')[0] || user?.name || 'Usuário' }}! 👋
        </h1>
        <p class="welcome-subtitle">
          Continue sua jornada de aprendizado. Hoje é um ótimo dia para aprender algo novo!
        </p>
      </div>

      <!-- Stats Cards -->
      <div class="stats-grid">
        <div class="stat-card">
          <div class="stat-icon bg-blue-100">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-6 w-6 text-blue-600"
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
          </div>
          <div class="stat-info">
            <h3 class="stat-value">12</h3>
            <p class="stat-label">Flashcards Estudados</p>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon bg-green-100">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-6 w-6 text-green-600"
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
          </div>
          <div class="stat-info">
            <h3 class="stat-value">85%</h3>
            <p class="stat-label">Taxa de Acerto</p>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon bg-purple-100">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-6 w-6 text-purple-600"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
              />
            </svg>
          </div>
          <div class="stat-info">
            <h3 class="stat-value">3</h3>
            <p class="stat-label">Dias de Sequência</p>
          </div>
        </div>
        <div class="stat-card">
          <div class="stat-icon bg-yellow-100">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-6 w-6 text-yellow-600"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M13 10V3L4 14h7v7l9-11h-7z"
              />
            </svg>
          </div>
          <div class="stat-info">
            <h3 class="stat-value">2h 30m</h3>
            <p class="stat-label">Tempo de Estudo</p>
          </div>
        </div>
      </div>

      <!-- Progress Section -->
      <div class="progress-section">
        <div class="progress-card">
          <h3 class="progress-title">Progresso Geral</h3>
          <div class="progress-bar-container">
            <div class="progress-bar" style="width: 65%"></div>
          </div>
          <p class="progress-text">65% completo - Continue assim!</p>
        </div>
      </div>

      <!-- Features Cards -->
      <div class="features-grid">
        <div class="feature-card" @click="router.push('/flashcards')">
          <div class="feature-icon-large bg-blue-500">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-8 w-8 text-white"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
              />
            </svg>
          </div>
          <div class="feature-content">
            <h3 class="feature-title">Flashcards</h3>
            <p class="feature-description">
              Estude com flashcards interativos e acelere seu aprendizado
            </p>
            <span class="feature-link">Começar agora →</span>
          </div>
        </div>

        <div class="feature-card" @click="router.push('/quizes')">
          <div class="feature-icon-large bg-green-500">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-8 w-8 text-white"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
              />
            </svg>
          </div>
          <div class="feature-content">
            <h3 class="feature-title">Quizes</h3>
            <p class="feature-description">Teste seus conhecimentos com quizzes personalizados</p>
            <span class="feature-link">Testar conhecimento →</span>
          </div>
        </div>

        <div class="feature-card" @click="router.push('/prompts')">
          <div class="feature-icon-large bg-purple-500">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-8 w-8 text-white"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"
              />
            </svg>
          </div>
          <div class="feature-content">
            <h3 class="feature-title">Prompts com IA</h3>
            <p class="feature-description">Gere prompts personalizados para praticar conversação</p>
            <span class="feature-link">Gerar prompts →</span>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const loading = ref(false)
const user = ref<any>(null)

onMounted(() => {
  const userData = localStorage.getItem('user')
  if (userData) {
    try {
      user.value = JSON.parse(userData)
    } catch (e) {
      console.error('Erro ao parsear user:', e)
    }
  }

  if (!user.value) {
    router.push('/login')
  }
})

const handleLogout = async () => {
  loading.value = true

  try {
    await fetch('http://localhost:8765/auth/logout', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
    })
  } catch (err) {
    console.error('Erro no logout:', err)
  } finally {
    localStorage.removeItem('user')
    localStorage.removeItem('auth_token')
    router.push('/login')
    loading.value = false
  }
}
</script>

<style scoped>
.dashboard-container {
  min-height: 100vh;
  background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
}

/* Navbar Modern */
.dashboard-nav {
  background: white;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
  position: sticky;
  top: 0;
  z-index: 100;
}

.nav-container {
  max-width: 1400px;
  margin: 0 auto;
  padding: 0 2rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  height: 70px;
}

.nav-brand {
  display: flex;
  align-items: center;
  gap: 12px;
}

.logo-icon {
  width: 40px;
  height: 40px;
  background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.logo-icon svg {
  color: white;
}

.nav-title {
  font-size: 1.5rem;
  font-weight: 700;
  background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.nav-menu {
  display: flex;
  gap: 8px;
  background: #f3f4f6;
  padding: 4px;
  border-radius: 12px;
}

.nav-link {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 8px 20px;
  border-radius: 8px;
  color: #6b7280;
  text-decoration: none;
  font-weight: 500;
  transition: all 0.3s ease;
}

.nav-link:hover {
  background: white;
  color: #7c3aed;
}

.nav-link.active {
  background: white;
  color: #7c3aed;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.nav-user {
  display: flex;
  align-items: center;
  gap: 16px;
}

.user-info {
  display: flex;
  align-items: center;
  gap: 12px;
}

.user-avatar {
  width: 40px;
  height: 40px;
  background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-weight: 600;
  font-size: 1rem;
}

.user-details {
  display: flex;
  flex-direction: column;
}

.user-name {
  font-weight: 600;
  color: #374151;
  font-size: 0.9rem;
}

.user-email {
  font-size: 0.75rem;
  color: #6b7280;
}

.logout-btn {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 8px 16px;
  background: #fee2e2;
  border: none;
  border-radius: 8px;
  color: #dc2626;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.3s ease;
}

.logout-btn:hover {
  background: #fecaca;
  transform: translateY(-1px);
}

.logout-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

/* Main Content */
.dashboard-main {
  max-width: 1400px;
  margin: 0 auto;
  padding: 2rem;
}

/* Welcome Section */
.welcome-section {
  margin-bottom: 2rem;
}

.welcome-title {
  font-size: 2rem;
  font-weight: 700;
  color: #1f2937;
  margin-bottom: 0.5rem;
}

.welcome-subtitle {
  color: #6b7280;
  font-size: 1rem;
}

/* Stats Cards */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: 1.5rem;
  margin-bottom: 2rem;
}

.stat-card {
  background: white;
  border-radius: 16px;
  padding: 1.5rem;
  display: flex;
  align-items: center;
  gap: 1rem;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
  transition: all 0.3s ease;
}

.stat-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.stat-icon {
  width: 48px;
  height: 48px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.stat-info {
  flex: 1;
}

.stat-value {
  font-size: 1.5rem;
  font-weight: 700;
  color: #1f2937;
  margin-bottom: 0.25rem;
}

.stat-label {
  font-size: 0.85rem;
  color: #6b7280;
}

/* Progress Section */
.progress-section {
  margin-bottom: 2rem;
}

.progress-card {
  background: white;
  border-radius: 16px;
  padding: 1.5rem;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.progress-title {
  font-size: 1rem;
  font-weight: 600;
  color: #374151;
  margin-bottom: 1rem;
}

.progress-bar-container {
  height: 8px;
  background: #e5e7eb;
  border-radius: 4px;
  overflow: hidden;
  margin-bottom: 0.5rem;
}

.progress-bar {
  height: 100%;
  background: linear-gradient(90deg, #7c3aed 0%, #a78bfa 100%);
  border-radius: 4px;
  transition: width 0.5s ease;
}

.progress-text {
  font-size: 0.85rem;
  color: #6b7280;
}

/* Features Cards */
.features-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
  gap: 1.5rem;
}

.feature-card {
  background: white;
  border-radius: 16px;
  padding: 1.5rem;
  display: flex;
  gap: 1rem;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.feature-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
}

.feature-icon-large {
  width: 56px;
  height: 56px;
  border-radius: 14px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.feature-content {
  flex: 1;
}

.feature-title {
  font-size: 1.25rem;
  font-weight: 600;
  color: #1f2937;
  margin-bottom: 0.5rem;
}

.feature-description {
  font-size: 0.9rem;
  color: #6b7280;
  margin-bottom: 0.75rem;
  line-height: 1.4;
}

.feature-link {
  font-size: 0.85rem;
  font-weight: 500;
  color: #7c3aed;
  transition: all 0.3s ease;
}

.feature-card:hover .feature-link {
  transform: translateX(4px);
  display: inline-block;
}

/* Responsive */
@media (max-width: 1024px) {
  .nav-container {
    padding: 0 1rem;
  }

  .nav-menu {
    display: none;
  }

  .user-details {
    display: none;
  }

  .dashboard-main {
    padding: 1rem;
  }

  .stats-grid {
    grid-template-columns: repeat(2, 1fr);
  }

  .features-grid {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 640px) {
  .stats-grid {
    grid-template-columns: 1fr;
  }

  .welcome-title {
    font-size: 1.5rem;
  }

  .nav-brand .nav-title {
    display: none;
  }
}

/* Background Colors */
.bg-blue-100 {
  background: #dbeafe;
}
.bg-green-100 {
  background: #d1fae5;
}
.bg-purple-100 {
  background: #ede9fe;
}
.bg-yellow-100 {
  background: #fef3c7;
}
.text-blue-600 {
  color: #2563eb;
}
.text-green-600 {
  color: #059669;
}
.text-purple-600 {
  color: #7c3aed;
}
.text-yellow-600 {
  color: #d97706;
}
</style>
