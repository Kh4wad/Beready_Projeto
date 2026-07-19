<template>
  <div class="quiz-form-page">
    <div class="quiz-form-hero">
      <button class="hero-back-btn" @click="$router.push('/quizes')">
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
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
            />
          </svg>
        </div>
        <h1 class="hero-title">{{ $t('quizes.newQuiz') }}</h1>
        <p class="hero-subtitle">{{ $t('quizes.createSubtitle') }}</p>
      </div>
    </div>

    <div class="quiz-form-container">
      <div class="quiz-form-card">
        <form @submit.prevent="handleSubmit">
          <div class="form-grid">
            <div class="form-group">
              <label class="form-label">{{ $t('quizes.titulo') }} *</label>
              <input
                v-model="form.titulo"
                type="text"
                class="form-input"
                :placeholder="$t('quizes.tituloPlaceholder')"
              />
              <span v-if="errors.titulo" class="form-error">{{ errors.titulo }}</span>
            </div>

            <div class="form-group">
              <label class="form-label">{{ $t('quizes.nivel') }}</label>
              <select v-model="form.nivel_dificuldade" class="form-select">
                <option value="iniciante">{{ $t('common.iniciante') }}</option>
                <option value="intermediario">{{ $t('common.intermediario') }}</option>
                <option value="avancado">{{ $t('common.avancado') }}</option>
              </select>
            </div>

            <div class="form-group full-width">
              <label class="form-label">{{ $t('quizes.descricao') }}</label>
              <textarea
                v-model="form.descricao"
                class="form-textarea"
                rows="4"
                :placeholder="$t('quizes.descricaoPlaceholder')"
              ></textarea>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label class="form-label">{{ $t('quizes.totalQuestoes') }}</label>
                <input
                  v-model.number="form.total_questoes"
                  type="number"
                  class="form-input"
                  :placeholder="$t('quizes.totalQuestoesPlaceholder')"
                />
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

          <div class="form-actions">
            <button type="button" class="btn-cancel" @click="$router.push('/quizes')">
              {{ $t('common.cancelar') }}
            </button>
            <button type="submit" class="btn-submit" :disabled="loading">
              {{ loading ? $t('common.salvando') : $t('quizes.createButton') }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useQuizAdd } from './QuizAdd'

const { form, errors, loading, handleSubmit } = useQuizAdd()
</script>

<style scoped>
@import '@/styles/views/quizes/quiz-form.css';
</style>
