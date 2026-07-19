<template>
  <div class="quiz-play-container">
    <div class="quiz-play-header">
      <button class="btn-back" @click="voltar">← $t('common.voltar')</button>
      <span v-if="!loading && !isFinished" class="progress-tracker">
        Questão {{ currentQuestionIndex + 1 }} de {{ totalQuestoes }}
      </span>
    </div>

    <div v-if="loading" class="state-message">$t('common.carregando')estões do quiz...</div>

    <div v-else-if="isFinished" class="state-message completion-card">
      <h2>🏆 Quiz Finalizado!</h2>
      <p>Suas respostas foram computadas com sucesso no banco de dados.</p>
      <button class="btn-primary" @click="voltar">$t('common.voltar') para Listagem</button>
    </div>

    <div v-else-if="currentQuestao" class="quiz-card">
      <div class="questao-section">
        <span class="label-type">ENUNCIADO</span>
        <p class="enunciado-text">{{ currentQuestao.enunciado }}</p>
      </div>

      <div class="alternativas-list">
        <button
          v-for="alt in currentQuestao.alternativas"
          :key="alt.id"
          class="btn-alternativa"
          :class="{
            'selected': selectedAlternativaId === alt.id,
            'correct-highlight': respondido && alt.correta,
            'wrong-highlight': respondido && selectedAlternativaId === alt.id && !alt.correta
          }"
          :disabled="respondido"
          @click="selectedAlternativaId = alt.id"
        >
          {{ alt.texto }}
        </button>
      </div>

      <div class="quiz-actions">
        <button
          v-if="!respondido"
          class="btn-action-confirm"
          :disabled="selectedAlternativaId === null"
          @click="verificarResposta"
        >
          Confirmar Resposta
        </button>
        <button v-else class="btn-action-next" @click="avançar">
          {{ currentQuestionIndex + 1 === totalQuestoes ? 'Finalizar Quiz' : 'Próxima Questão →' }}
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useQuizPlay } from './QuizPlay'

const {
  currentQuestao,
  currentQuestionIndex,
  selectedAlternativaId,
  respondido,
  loading,
  isFinished,
  totalQuestoes,
  verificarResposta,
  avançar,
  voltar
} = useQuizPlay()
</script>

<style scoped>
.quiz-play-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
  color: white;
  padding: 20px;
  position: relative;
}
.quiz-play-header {
  position: absolute;
  top: 20px;
  width: 90%;
  display: flex;
  justify-content: space-between;
}
.quiz-card {
  background: white;
  color: #333;
  border-radius: 12px;
  padding: 30px;
  width: 100%;
  max-width: 600px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.3);
}
.label-type {
  font-size: 11px;
  font-weight: bold;
  color: #3b82f6;
  letter-spacing: 1px;
}
.enunciado-text {
  font-size: 18px;
  font-weight: 600;
  margin: 15px 0 25px 0;
}
.alternativas-list {
  display: flex;
  flex-direction: column;
  gap: 12px;
}
.btn-alternativa {
  background: #f3f4f6;
  border: 2px solid transparent;
  color: #374151;
  padding: 14px;
  border-radius: 8px;
  text-align: left;
  font-size: 15px;
  cursor: pointer;
  transition: all 0.2s;
}
.btn-alternativa:hover:not(:disabled) {
  background: #e5e7eb;
}
.btn-alternativa.selected {
  border-color: #3b82f6;
  background: #eff6ff;
}
.btn-alternativa.correct-highlight {
  background: #dcfce7 !important;
  color: #166534 !important;
  border-color: #22c55e !important;
}
.btn-alternativa.wrong-highlight {
  background: #fee2e2 !important;
  color: #991b1b !important;
  border-color: #ef4444 !important;
}
.quiz-actions {
  margin-top: 25px;
}
.btn-action-confirm, .btn-action-next {
  width: 100%;
  padding: 12px;
  border-radius: 8px;
  font-weight: bold;
  border: none;
  cursor: pointer;
}
.btn-action-confirm { background: #3b82f6; color: white; }
.btn-action-confirm:disabled { background: #cbd5e1; cursor: not-allowed; }
.btn-action-next { background: #10b981; color: white; }
</style>