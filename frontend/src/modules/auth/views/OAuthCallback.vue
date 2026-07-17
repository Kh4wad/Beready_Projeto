<template>
  <div class="oauth-callback-page">
    <div class="oauth-callback-container">
      <div v-if="loading" class="loading-spinner">
        <div class="spinner"></div>
        <p class="loading-text">Autenticando com Google...</p>
      </div>

      <div v-if="error" class="error-message">
        <p>❌ {{ error }}</p>
        <button @click="goToLogin" class="btn-retry">Voltar para o login</button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useOAuthCallback } from './OAuthCallback'

const { error, loading, goToLogin } = useOAuthCallback()
</script>

<style scoped>
@import '@/styles/views/auth/oauth-callback.css';
</style>
