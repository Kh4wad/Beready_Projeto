<template>
  <nav class="dashboard-nav">
    <div class="nav-container">
      <!-- Logo -->
      <div class="nav-brand">
        <img src="/logo.png" alt="Beready Logo" class="logo-icon-img" />
      </div>

      <!-- Desktop Menu -->
      <div class="nav-menu">
        <router-link
          v-for="item in menuItems"
          :key="item.path"
          :to="item.path"
          class="nav-link"
          active-class="active"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              :d="item.iconPath"
            />
          </svg>
          {{ item.name }}
        </router-link>
      </div>

      <!-- User + Hamburger -->
      <div class="nav-user">
        <div class="user-info">
          <div class="user-avatar">
            <img
              v-if="user?.foto_perfil"
              :src="user.foto_perfil"
              alt="Foto de perfil"
              class="avatar-image"
            />
            <span v-else>{{ user?.nome?.charAt(0) || 'U' }}</span>
          </div>
          <div class="user-details">
            <span class="user-name">{{ user?.nome || 'Usuário' }}</span>
            <span class="user-email">{{ user?.email || '' }}</span>
          </div>
        </div>

        <button class="logout-btn" @click="handleLogout">
          <svg
            xmlns="http://www.w3.org/2000/svg"
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
          <span>Sair</span>
        </button>

        <button
          class="hamburger-btn"
          @click="toggleMenu"
          :class="{ active: isMenuOpen }"
          aria-label="Alternar menu"
        >
          <span class="hamburger-line"></span>
          <span class="hamburger-line"></span>
          <span class="hamburger-line"></span>
        </button>
      </div>
    </div>

    <!-- Mobile Menu -->
    <transition name="slide-down">
      <div v-if="isMenuOpen" class="mobile-menu">
        <div class="mobile-menu-items">
          <router-link
            v-for="item in menuItems"
            :key="item.path"
            :to="item.path"
            class="mobile-nav-link"
            @click="closeMenu"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                :d="item.iconPath"
              />
            </svg>
            {{ item.name }}
          </router-link>

          <button class="mobile-logout-btn" @click="handleLogout">
            <svg
              xmlns="http://www.w3.org/2000/svg"
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
            Sair
          </button>
        </div>
      </div>
    </transition>
  </nav>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAlert } from '@/shared/composables/useAlert'
import { useNavbar } from './Navbar'
import type { User } from '@/core/types/User'

const props = defineProps<{
  user: User | null
  loading?: boolean
}>()

const emit = defineEmits<{
  (e: 'logout'): void
}>()

const router = useRouter()
const { success } = useAlert()
const isMenuOpen = ref(false)

const { menuItems } = useNavbar(props)

const toggleMenu = () => {
  isMenuOpen.value = !isMenuOpen.value
  document.body.style.overflow = isMenuOpen.value ? 'hidden' : ''
}

const closeMenu = () => {
  isMenuOpen.value = false
  document.body.style.overflow = ''
}

const handleLogout = () => {
  closeMenu()
  localStorage.removeItem('user')
  localStorage.removeItem('token')
  success('Logout realizado com sucesso!')
  setTimeout(() => {
    router.push('/login')
  }, 500)
  emit('logout')
}
</script>

<style scoped>
@import '@/styles/components/navbar.css';
</style>
