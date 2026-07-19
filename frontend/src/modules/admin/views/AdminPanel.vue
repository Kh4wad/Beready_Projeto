<template>
  <div class="admin-panel-page">
    <!-- Header com gradiente -->
    <div class="admin-header">
      <button class="back-btn" @click="$router.push('/dashboard')">
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
            d="M10 19l-7-7m0 0l7-7m-7 7h18"
          />
        </svg>
        {{ $t('common.voltar') }}
      </button>
      <div class="header-content">
        <div class="header-icon">
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
              d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
            />
          </svg>
        </div>
        <div class="header-text">
          <h1>{{ $t('admin.title') }}</h1>
          <p>
            {{ $t('admin.welcome', { name: user?.nome }) }}
            <span class="admin-chip">{{ $t('admin.badge') }}</span>
          </p>
        </div>
      </div>
    </div>

    <!-- Tabs estilizadas -->
    <div class="admin-tabs">
      <button :class="['tab-btn', { active: activeTab === 'users' }]" @click="activeTab = 'users'">
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
            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
          />
        </svg>
        {{ $t('admin.users') }}
      </button>
      <button :class="['tab-btn', { active: activeTab === 'stats' }]" @click="activeTab = 'stats'">
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
            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
          />
        </svg>
        {{ $t('admin.statistics') }}
      </button>
    </div>

    <!-- Tab Usuários -->
    <div v-if="activeTab === 'users'" class="admin-users">
      <div class="users-header">
        <h2>{{ $t('admin.manageUsers') }}</h2>
        <div class="search-box">
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
              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
            />
          </svg>
          <input
            type="text"
            v-model="searchQuery"
            :placeholder="$t('admin.searchPlaceholder')"
          />
        </div>
      </div>

      <div v-if="loadingUsers" class="loading-state">
        <div class="spinner"></div>
        <p>{{ $t('admin.loadingUsers') }}</p>
      </div>

      <div v-else class="users-table-wrapper">
        <table class="users-table">
          <thead>
            <tr>
              <th>{{ $t('admin.id') }}</th>
              <th>{{ $t('admin.user') }}</th>
              <th>{{ $t('login.email') }}</th>
              <th>{{ $t('admin.level') }}</th>
              <th>{{ $t('admin.status') }}</th>
              <th>{{ $t('admin.actions') }}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="userItem in filteredUsers" :key="userItem.id">
              <td>
                <span class="user-id">#{{ userItem.id }}</span>
              </td>
              <td>
                <div class="user-name-cell">
                  <div class="user-avatar">{{ userItem.nome?.charAt(0) || 'U' }}</div>
                  <span class="user-name">{{ userItem.nome }}</span>
                </div>
              </td>
              <td>{{ userItem.email }}</td>
              <td>
                <span :class="['role-badge', userItem.role]">
                  {{ userItem.role === 'admin' ? '👑 ' + $t('admin.admin') : '👤 ' + $t('admin.user') }}
                </span>
              </td>
              <td>
                <span :class="['status-badge', userItem.status]">
                  {{ userItem.status === 'ativo' ? '🟢 ' + $t('admin.active') : '🔴 ' + $t('admin.inactive') }}
                </span>
              </td>
              <td>
                <button
                  v-if="userItem.id !== currentUserId"
                  @click="toggleRole(userItem)"
                  class="action-btn"
                  :class="userItem.role === 'admin' ? 'rebaixar' : 'promover'"
                  :disabled="updatingRole === userItem.id"
                >
                  {{
                    updatingRole === userItem.id
                      ? '...'
                      : userItem.role === 'admin'
                        ? $t('admin.demote')
                        : $t('admin.promote')
                  }}
                </button>
                <span v-else class="current-user-badge">{{ $t('admin.you') }}</span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Tab Estatísticas -->
    <div v-if="activeTab === 'stats'" class="admin-stats">
      <div class="stats-cards">
        <div class="stat-card">
          <div class="stat-icon purple">
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
                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
              />
            </svg>
          </div>
          <div class="stat-value">{{ stats.total_users || 0 }}</div>
          <div class="stat-label">{{ $t('admin.totalUsers') }}</div>
        </div>
        <div class="stat-card">
          <div class="stat-icon blue">
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
                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
              />
            </svg>
          </div>
          <div class="stat-value">{{ stats.total_flashcards || 0 }}</div>
          <div class="stat-label">{{ $t('common.flashcards') }}</div>
        </div>
        <div class="stat-card">
          <div class="stat-icon green">
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
                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
              />
            </svg>
          </div>
          <div class="stat-value">{{ stats.total_quizes || 0 }}</div>
          <div class="stat-label">{{ $t('common.quizes') }}</div>
        </div>
        <div class="stat-card">
          <div class="stat-icon orange">
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
                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"
              />
            </svg>
          </div>
          <div class="stat-value">{{ stats.total_prompts || 0 }}</div>
          <div class="stat-label">{{ $t('common.prompts') }}</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useAdminPanel } from './AdminPanel'

const {
  user,
  activeTab,
  users,
  loadingUsers,
  updatingRole,
  searchQuery,
  stats,
  currentUserId,
  filteredUsers,
  toggleRole,
} = useAdminPanel()
</script>

<style scoped>
@import '@/styles/views/admin/admin-panel.css';
</style>