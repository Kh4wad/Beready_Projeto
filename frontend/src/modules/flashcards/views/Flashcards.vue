<template>
  <div class="flashcards-page">
    <div class="flashcards-hero">
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
            <rect x="2" y="4" width="20" height="16" rx="2" />
            <path d="M8 8h8M8 12h6" />
          </svg>
        </div>
        <h1 class="hero-title">{{ $t('flashcards.title') }}</h1>
        <p class="hero-subtitle">{{ $t('flashcards.subtitle') }}</p>
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
          {{ $t('flashcards.newFlashcard') }}
        </button>
      </div>
    </div>

    <!-- Loading -->
    <div v-if="loading" class="loading-state">
      <div class="spinner"></div>
      <p>{{ $t('flashcards.carregando') }}</p>
    </div>

    <!-- Empty -->
    <div v-else-if="flashcards.length === 0" class="empty-state">
      <div class="empty-icon">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-12 w-12"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <rect x="2" y="4" width="20" height="16" rx="2" />
          <path d="M8 8h8M8 12h6" />
        </svg>
      </div>
      <h2 class="empty-title">{{ $t('flashcards.emptyTitle') }}</h2>
      <p class="empty-description">{{ $t('flashcards.emptyDescription') }}</p>
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
        {{ $t('flashcards.createFirst') }}
      </button>
    </div>

    <!-- Grid -->
    <div v-else class="flashcards-grid">
      <div v-for="flashcard in flashcards" :key="flashcard.id" class="flashcard-card">
        <div class="flashcard-card-actions">
          <button class="btn-edit" @click.stop="openEditModal(flashcard)">
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
          <button class="btn-delete" @click.stop="confirmDelete(flashcard)">
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
        <div class="flashcard-content" @click="viewFlashcard(flashcard.id)">
          <div class="flashcard-question">
            <div class="question-label">{{ $t('flashcards.perguntaLabel') }}</div>
            <div class="question-text">{{ flashcard.frente }}</div>
          </div>
          <div class="flashcard-answer">
            <div class="answer-label">{{ $t('flashcards.respostalabel') }}</div>
            <div class="answer-text">{{ flashcard.verso }}</div>
          </div>
        </div>
        <div class="flashcard-footer">
          <button class="btn-study" @click.stop="studyFlashcard(flashcard.id)">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-4 w-4"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <circle cx="12" cy="12" r="10" />
              <path d="M12 8v4l3 3" />
            </svg>
            {{ $t('flashcards.estudar') }}
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
              {{ isEditing ? $t('flashcards.editFlashcard') : $t('flashcards.newFlashcard') }}
            </h2>
            <p class="modal-subtitle">
              {{ isEditing ? $t('flashcards.editSubtitle') : $t('flashcards.createSubtitle') }}
            </p>
          </div>
          <button class="modal-close" @click="closeModal">×</button>
        </div>
        <form @submit.prevent="submitForm">
          <div class="modal-body">
            <div class="form-group">
              <label class="form-label">{{ $t('flashcards.pergunta') }}</label>
              <textarea
                v-model="form.frente"
                class="form-textarea"
                rows="3"
                required
                :placeholder="$t('flashcards.perguntaPlaceholder')"
              ></textarea>
            </div>
            <div class="form-group">
              <label class="form-label">{{ $t('flashcards.resposta') }}</label>
              <textarea
                v-model="form.verso"
                class="form-textarea"
                rows="3"
                required
                :placeholder="$t('flashcards.respostaPlaceholder')"
              ></textarea>
            </div>
            <div class="form-group">
              <label class="form-label">{{ $t('flashcards.dificuldade') }}</label>
              <select v-model="form.nivel_dificuldade" class="form-select">
                <option value="facil">{{ $t('flashcards.facil') }}</option>
                <option value="medio">{{ $t('flashcards.medio') }}</option>
                <option value="dificil">{{ $t('flashcards.dificil') }}</option>
              </select>
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
          <h2 class="modal-title">{{ $t('flashcards.confirmDelete') }}</h2>
        </div>
        <div class="confirm-body">
          <p>{{ $t('flashcards.deleteConfirmMessage') }}</p>
          <p class="flashcard-name">"{{ deletingFlashcard?.frente }}"</p>
          <p class="modal-warning">⚠️ {{ $t('flashcards.deleteWarning') }}</p>
        </div>
        <div class="confirm-footer">
          <button class="btn-cancel" @click="showDeleteModal = false">
            {{ $t('common.cancelar') }}
          </button>
          <button class="btn-delete-confirm" @click="handleDelete" :disabled="deleting">
            {{ deleting ? $t('common.excluindo') : $t('flashcards.confirmDeleteButton') }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useFlashcardsView } from './Flashcards'

const {
  flashcards,
  loading,
  showModal,
  showDeleteModal,
  isEditing,
  deletingFlashcard,
  submitting,
  deleting,
  form,
  openCreateModal,
  openEditModal,
  viewFlashcard,
  studyFlashcard,
  confirmDelete,
  handleDelete,
  submitForm,
  closeModal,
} = useFlashcardsView()
</script>

<style scoped>
@import '@/styles/views/flashcards/flashcards.css';
</style>
