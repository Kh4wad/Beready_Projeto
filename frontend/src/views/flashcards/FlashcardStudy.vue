<template>
  <div class="flashcard-study-page">
    <div class="flashcard-study-container">
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

      <div v-else class="study-card">
        <div class="study-header">
          <span class="difficulty-badge" :class="getLevelClass(flashcard.nivel_dificuldade)">
            {{ getLevelText(flashcard.nivel_dificuldade) }}
          </span>
          <div class="study-progress">
            <span class="progress-text">{{ currentIndex + 1 }} / {{ flashcards.length }}</span>
          </div>
        </div>

        <div class="study-content" @click="flipCard">
          <div class="study-card-inner" :class="{ flipped: isFlipped }">
            <div class="study-card-front">
              <div class="card-label">Pergunta</div>
              <p class="card-text">{{ currentFlashcard?.frente }}</p>
              <div class="flip-hint">
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
                    d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"
                  />
                </svg>
                Clique para ver a resposta
              </div>
            </div>
            <div class="study-card-back">
              <div class="card-label">Resposta</div>
              <p class="card-text">{{ currentFlashcard?.verso }}</p>
              <div class="flip-hint">
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
                    d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"
                  />
                </svg>
                Clique para ver a pergunta
              </div>
            </div>
          </div>
        </div>

        <div class="study-actions">
          <button class="nav-btn" @click="previousCard" :disabled="currentIndex === 0">
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
            Anterior
          </button>
          <div class="rating-buttons" v-if="isFlipped">
            <button class="rating-btn hard" @click="rateCard('hard')">Difícil</button>
            <button class="rating-btn good" @click="rateCard('good')">Bom</button>
            <button class="rating-btn easy" @click="rateCard('easy')">Fácil</button>
          </div>
          <button
            class="nav-btn"
            @click="nextCard"
            :disabled="currentIndex === flashcards.length - 1"
          >
            Próximo
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
                d="M9 5l7 7-7 7"
              />
            </svg>
          </button>
        </div>

        <div class="study-footer">
          <button class="finish-btn" @click="finishStudy">
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
                d="M5 13l4 4L19 7"
              />
            </svg>
            Finalizar estudo
          </button>
        </div>
      </div>
    </div>

    <!-- Completion Modal -->
    <div v-if="showCompletionModal" class="modal-overlay" @click.self="showCompletionModal = false">
      <div class="modal-container completion-modal">
        <div class="completion-icon">
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
              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
            />
          </svg>
        </div>
        <h3 class="completion-title">Estudo concluído! 🎉</h3>
        <p class="completion-message">Você revisou {{ flashcards.length }} flashcards.</p>
        <div class="completion-stats">
          <div class="stat">
            <span class="stat-label">Difíceis:</span>
            <span class="stat-value">{{ stats.hard }}</span>
          </div>
          <div class="stat">
            <span class="stat-label">Bons:</span>
            <span class="stat-value">{{ stats.good }}</span>
          </div>
          <div class="stat">
            <span class="stat-label">Fáceis:</span>
            <span class="stat-value">{{ stats.easy }}</span>
          </div>
        </div>
        <div class="completion-actions">
          <button class="completion-btn" @click="studyAgain">Estudar novamente</button>
          <button class="completion-btn secondary" @click="goBack">Voltar</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useFlashcardStudy } from './FlashcardStudy'

const {
  flashcard,
  flashcards,
  currentIndex,
  currentFlashcard,
  loading,
  isFlipped,
  showCompletionModal,
  stats,
  goBack,
  flipCard,
  nextCard,
  previousCard,
  rateCard,
  finishStudy,
  studyAgain,
  getLevelClass,
  getLevelText,
} = useFlashcardStudy()
</script>

<style scoped>
@import '@/styles/views/flashcards/flashcard-study.css';
</style>
