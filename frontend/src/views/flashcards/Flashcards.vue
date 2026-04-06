<template>
  <div class="flashcards-page">
    <!-- Hero Section -->
    <div class="flashcards-hero">
      <div class="hero-content">
        <button class="hero-back-btn" @click="handleBack">
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
        <div class="hero-icon">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-12 w-12"
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
        <h1 class="hero-title">Flashcards</h1>
        <p class="hero-subtitle">Estude com flashcards interativos</p>
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
          Criar Flashcard
        </button>
      </div>
    </div>

    <!-- Loading State -->
    <div v-if="loading" class="loading-state">
      <div class="spinner"></div>
      <p>Carregando flashcards...</p>
    </div>

    <!-- Empty State -->
    <div v-else-if="flashcards.length === 0" class="empty-state">
      <div class="empty-icon">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-20 w-20"
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
      <h3 class="empty-title">Nenhum flashcard encontrado</h3>
      <p class="empty-description">Comece criando seu primeiro flashcard!</p>
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
        Criar Primeiro Flashcard
      </button>
    </div>

    <!-- Flashcards Grid -->
    <div v-else class="flashcards-grid">
      <div v-for="flashcard in flashcards" :key="flashcard.id" class="flashcard-card">
        <div class="flashcard-actions">
          <button class="btn-edit" @click.stop="editFlashcard(flashcard)">
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
          </button>
          <button class="btn-delete" @click.stop="openDeleteModal(flashcard.id, flashcard.frente)">
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
                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
              />
            </svg>
          </button>
        </div>
        <div class="flashcard-content" @click="viewFlashcard(flashcard.id)">
          <div class="flashcard-question">
            <span class="question-label">Pergunta:</span>
            <p class="question-text">{{ flashcard.frente }}</p>
          </div>
          <div class="flashcard-answer">
            <span class="answer-label">Resposta:</span>
            <p class="answer-text">{{ flashcard.verso }}</p>
          </div>
        </div>
        <div class="flashcard-footer">
          <button class="btn-study" @click="studyFlashcard(flashcard.id)">
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
            Estudar
          </button>
        </div>
      </div>
    </div>

    <!-- Create/Edit Modal -->
    <div v-if="showModal" class="modal-overlay" @click.self="closeModal">
      <div class="modal-container">
        <div class="modal-header">
          <div>
            <h3 class="modal-title">{{ isEditing ? 'Editar Flashcard' : 'Criar Flashcard' }}</h3>
            <p class="modal-subtitle">
              {{ isEditing ? 'Atualize as informações' : 'Preencha os dados abaixo' }}
            </p>
          </div>
          <button class="modal-close" @click="closeModal">×</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label class="form-label">Pergunta (Frente) *</label>
            <textarea
              v-model="form.frente"
              class="form-textarea"
              rows="3"
              placeholder="Digite a pergunta..."
            ></textarea>
          </div>
          <div class="form-group">
            <label class="form-label">Resposta (Verso) *</label>
            <textarea
              v-model="form.verso"
              class="form-textarea"
              rows="3"
              placeholder="Digite a resposta..."
            ></textarea>
          </div>
          <div class="form-group">
            <label class="form-label">Nível de Dificuldade</label>
            <select v-model="form.nivel_dificuldade" class="form-select">
              <option value="iniciante">🌱 Iniciante</option>
              <option value="intermediario">📚 Intermediário</option>
              <option value="avancado">🎯 Avançado</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn-cancel" @click="closeModal">Cancelar</button>
          <button class="btn-create" @click="saveFlashcard" :disabled="saving">
            {{ saving ? 'Salvando...' : isEditing ? 'Salvar' : 'Criar' }}
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
      :item-name="flashcardToDeleteTitle"
      :loading="deleting"
      @confirm="confirmDelete"
    />
  </div>
</template>

<script setup lang="ts">
import { useRouter } from 'vue-router'
import { useFlashcards } from './Flashcards'
import ConfirmModal from '@/components/common/ConfirmModal.vue'

const router = useRouter()
const {
  flashcards,
  loading,
  saving,
  deleting,
  showModal,
  showConfirmModal,
  isEditing,
  form,
  flashcardToDeleteTitle,
  viewFlashcard,
  studyFlashcard,
  editFlashcard,
  saveFlashcard,
  closeModal,
  openDeleteModal,
  confirmDelete,
  openCreateModal,
  formatDate,
} = useFlashcards()

const handleBack = () => {
  router.push('/dashboard')
}
</script>

<style scoped>
@import '@/styles/views/flashcards/flashcards.css';
</style>
