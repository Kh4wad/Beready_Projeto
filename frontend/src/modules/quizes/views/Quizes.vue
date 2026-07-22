<template>
  <div class="quizes-page">
    <div class="quizes-hero">
      <button class="hero-back-btn" @click="$router.push('/dashboard')">
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
        {{ $t('common.voltar') }}
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
              d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"
            />
            <circle cx="12" cy="12" r="3" />
          </svg>
        </div>
        <h1 class="hero-title">{{ $t('quizes.title') }}</h1>
        <p class="hero-subtitle">{{ $t('quizes.subtitle') }}</p>
        <button class="hero-btn" @click="openCreateModal">
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
              d="M12 4v16m8-8H4"
            />
          </svg>
          {{ $t('quizes.newQuiz') }}
        </button>
      </div>
    </div>

    <!-- Loading -->
    <div v-if="loading" class="loading-state">
      <div class="spinner"></div>
      <p>{{ $t('quizes.carregando') }}</p>
    </div>

    <!-- Empty -->
    <div v-else-if="quizes.length === 0" class="empty-state">
      <div class="empty-icon">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-12 w-12"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"
          />
          <circle cx="12" cy="12" r="3" />
        </svg>
      </div>
      <h2 class="empty-title">{{ $t('quizes.emptyTitle') }}</h2>
      <p class="empty-description">{{ $t('quizes.emptyDescription') }}</p>
      <button class="empty-btn" @click="openCreateModal">
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
            d="M12 4v16m8-8H4"
          />
        </svg>
        {{ $t('quizes.createFirst') }}
      </button>
    </div>

    <!-- Grid -->
    <div v-else class="quizes-grid">
      <div v-for="quiz in quizes" :key="quiz.id" class="quiz-card">
        <div class="quiz-card-actions">
          <button class="btn-edit" @click.stop="openEditModal(quiz)">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-4 w-4"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
              />
            </svg>
          </button>
          <button class="btn-delete" @click.stop="confirmDelete(quiz)">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-4 w-4"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
              />
            </svg>
          </button>
        </div>
        <span class="quiz-card-badge" :class="getLevelClass(quiz.nivel_dificuldade)">
          {{ getDifficultyText(quiz.nivel_dificuldade) }}
        </span>
        <div class="quiz-card-content" @click="viewQuiz(quiz.id)">
          <h3 class="quiz-card-title">{{ quiz.titulo }}</h3>
          <p class="quiz-card-description">{{ quiz.descricao || $t('quizes.semDescricao') }}</p>
          <div class="quiz-card-stats">
            <span class="stat">📝 {{ quiz.total_questoes || 0 }} {{ $t('quizes.questoes') }}</span>
            <span class="stat">⏱️ {{ quiz.tempo_limite || $t('quizes.semLimite') }} min</span>
          </div>
        </div>
        <div class="quiz-card-footer">
          <button class="btn-play" @click.stop="playQuiz(quiz.id)">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-4 w-4"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <polygon points="5 3 19 12 5 21 5 3" />
            </svg>
            {{ $t('quizes.jogar') }}
          </button>
        </div>
      </div>
    </div>

    <!-- Modal de Criar/Editar -->
    <div v-if="showModal" class="modal-overlay" @click="closeModal">
      <div class="modal-container" @click.stop>
        <div class="modal-header">
          <div>
            <h2 class="modal-title">
              {{ isEditing ? $t('quizes.editQuiz') : $t('quizes.newQuiz') }}
            </h2>
            <p class="modal-subtitle">
              {{ isEditing ? $t('quizes.editSubtitle') : $t('quizes.createSubtitle') }}
            </p>
          </div>
          <button class="modal-close" @click="closeModal">×</button>
        </div>
        <form @submit.prevent="submitForm">
          <div class="modal-body">
            <div class="form-group">
              <label class="form-label">{{ $t('quizes.titulo') }} *</label>
              <input
                v-model="form.titulo"
                type="text"
                class="form-input"
                required
                :placeholder="$t('quizes.tituloPlaceholder')"
              />
            </div>
            <div class="form-group">
              <label class="form-label">{{ $t('quizes.descricao') }}</label>
              <textarea
                v-model="form.descricao"
                class="form-textarea"
                rows="3"
                :placeholder="$t('quizes.descricaoPlaceholder')"
              ></textarea>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label class="form-label">{{ $t('quizes.nivel') }}</label>
                <select v-model="form.nivel_dificuldade" class="form-select">
                  <option value="iniciante">{{ $t('common.iniciante') }}</option>
                  <option value="intermediario">{{ $t('common.intermediario') }}</option>
                  <option value="avancado">{{ $t('common.avancado') }}</option>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">{{ $t('quizes.tempoLimite') }}</label>
                <input
                  v-model.number="form.tempo_limite"
                  type="number"
                  class="form-input"
                  :placeholder="$t('quizes.tempoPlaceholder')"
                />
              </div>
            </div>
            <div class="form-group">
              <label class="form-checkbox">
                <input v-model="form.publico" type="checkbox" />
                <span>{{ $t('quizes.publico') }}</span>
              </label>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn-cancel" @click="closeModal">
              {{ $t('common.cancelar') }}
            </button>
            <button type="submit" class="btn-create" :disabled="submitting">
              {{
                submitting
                  ? $t('common.salvando')
                  : isEditing
                    ? $t('common.atualizar')
                    : $t('common.criar')
              }}
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Modal de Confirmação de Exclusão -->
    <div v-if="showDeleteModal" class="modal-overlay" @click="showDeleteModal = false">
      <div class="modal-container confirm-modal" @click.stop>
        <div class="confirm-header">
          <div class="confirm-icon">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="35"
              height="35"
              viewBox="0 0 24 24"
              fill="none"
              stroke="white"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            >
              <circle cx="12" cy="12" r="10"></circle>
              <line x1="12" y1="8" x2="12" y2="12"></line>
              <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
          </div>
          <h2 class="modal-title">{{ $t('quizes.confirmDelete') }}</h2>
        </div>
        <div class="confirm-body">
          <p>{{ $t('quizes.deleteConfirmMessage') }}</p>
          <p class="quiz-name">"{{ deletingQuiz?.titulo }}"</p>
          <p class="modal-warning"> {{ $t('flashcards.deleteWarning') }}</p>
        </div>
        <div class="confirm-footer">
          <button class="btn-cancel" @click="showDeleteModal = false">
            {{ $t('common.cancelar') }}
          </button>
          <button class="btn-delete-confirm" @click="handleDelete" :disabled="deleting">
            {{ deleting ? $t('common.excluindo') : $t('quizes.confirmDeleteButton') }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useQuizesView } from './Quizes'

const {
  quizes,
  loading,
  showModal,
  showDeleteModal,
  isEditing,
  deletingQuiz,
  submitting,
  deleting,
  form,
  openCreateModal,
  openEditModal,
  viewQuiz,
  playQuiz,
  confirmDelete,
  handleDelete,
  submitForm,
  closeModal,
  getDifficultyText,
  getLevelClass,
} = useQuizesView()
</script>

<style scoped>
@import '@/styles/views/quizes/quizes.css';
</style>
