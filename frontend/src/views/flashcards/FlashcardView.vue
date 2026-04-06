<template>
  <div class="flashcard-view-page">
    <div class="flashcard-view-container">
      <button class="back-btn" @click="goBack">
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
            d="M15 19l-7-7 7-7"
          />
        </svg>
        Voltar
      </button>

      <div v-if="loading" class="loading-container">
        <div class="spinner"></div>
        <p>Carregando flashcard...</p>
      </div>

      <div v-else-if="!flashcard" class="error-container">
        <div class="error-icon">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-16 w-16"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
            />
          </svg>
        </div>
        <h3 class="error-title">Flashcard não encontrado</h3>
        <p class="error-description">O flashcard que você está procurando não existe.</p>
        <button class="error-btn" @click="goBack">Voltar para lista</button>
      </div>

      <div v-else class="flashcard-view-card">
        <div class="flashcard-view-header">
          <span class="difficulty-badge" :class="getLevelClass(flashcard.nivel_dificuldade)">
            {{ getLevelText(flashcard.nivel_dificuldade) }}
          </span>
          <div class="flashcard-view-actions">
            <button class="action-btn edit" @click="editFlashcard">
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
                  d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
                />
              </svg>
              Editar
            </button>
            <button class="action-btn delete" @click="openDeleteModal">
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
                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                />
              </svg>
              Excluir
            </button>
          </div>
        </div>

        <div class="flashcard-view-content">
          <div class="question-section">
            <div class="section-label">
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
                  d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                />
              </svg>
              Pergunta
            </div>
            <p class="question-text">{{ flashcard.frente }}</p>
          </div>

          <div class="answer-section">
            <div class="section-label">
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
                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                />
              </svg>
              Resposta
            </div>
            <p class="answer-text">{{ flashcard.verso }}</p>
          </div>

          <div class="metadata-section">
            <div class="metadata-item">
              <span class="metadata-label">Criado em:</span>
              <span class="metadata-value">{{ formatDate(flashcard.criado_em) }}</span>
            </div>
            <div class="metadata-item">
              <span class="metadata-label">Última atualização:</span>
              <span class="metadata-value">{{ formatDate(flashcard.atualizado_em) }}</span>
            </div>
          </div>
        </div>

        <div class="flashcard-view-footer">
          <button class="study-btn" @click="studyFlashcard">
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
                d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"
              />
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
              />
            </svg>
            Estudar este flashcard
          </button>
        </div>
      </div>
    </div>

    <!-- Confirm Delete Modal -->
    <ConfirmModal
      v-model="showConfirmModal"
      title="Excluir Flashcard"
      message="Tem certeza que deseja excluir este flashcard?"
      confirm-text="Sim, excluir"
      type="danger"
      :item-name="flashcard?.frente"
      :loading="deleting"
      @confirm="confirmDelete"
    />
  </div>
</template>

<script setup lang="ts">
import { useFlashcardView } from './FlashcardView'
import ConfirmModal from '@/components/common/ConfirmModal.vue'

const {
  flashcard,
  loading,
  deleting,
  showConfirmModal,
  goBack,
  editFlashcard,
  studyFlashcard,
  confirmDelete,
  getLevelClass,
  getLevelText,
  formatDate,
} = useFlashcardView()
</script>

<style scoped>
@import '@/styles/views/flashcards/flashcard-view.css';
</style>
