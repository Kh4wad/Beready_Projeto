<template>
  <div class="flashcard-study-container">
    <div class="study-header">
      <button class="btn-back" @click="goBack">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Voltar
      </button>
      <div v-if="flashcard" class="badge-container">
        <span class="badge" :class="getLevelClass(flashcard.nivel_dificuldade)">
          {{ getLevelText(flashcard.nivel_dificuldade) }}
        </span>
      </div>
    </div>

    <div v-if="loading" class="loading-state">
      <div class="spinner"></div>
      <p>Carregando flashcard...</p>
    </div>

    <div v-else-if="flashcard" class="study-body">
      <div class="flashcard-wrapper" :class="{ 'flipped': isFlipped }" @click="flipCard">
        <div class="flashcard-inner">
          
          <div class="flashcard-face flashcard-front">
            <div class="face-header">
              <span class="indicator-tag question">PERGUNTA</span>
            </div>
            <div class="face-content">
              <p class="text-display">{{ flashcard.pergunta }}</p>
            </div>
            <div class="face-footer">
              <span class="hint-text">Clique no card para revelar a resposta</span>
            </div>
          </div>

          <div class="flashcard-face flashcard-back">
            <div class="face-header">
              <span class="indicator-tag answer">RESPOSTA</span>
            </div>
            <div class="face-content">
              <p class="text-display">{{ flashcard.resposta }}</p>
            </div>
            <div class="face-footer-empty"></div>
          </div>

        </div>
      </div>

      <div class="action-dock" :class="{ 'visible': isFlipped }">
        <p class="dock-title">Como foi lembrar dessa resposta?</p>
        <div class="dock-buttons">
          <button class="btn-rate rate-hard" @click.stop="rateCard('hard')">
            <span class="icon">❌</span>
            <span class="label">Errei</span>
          </button>
          <button class="btn-rate rate-good" @click.stop="rateCard('good')">
            <span class="icon">🤝</span>
            <span class="label">Bom</span>
          </button>
          <button class="btn-rate rate-easy" @click.stop="rateCard('easy')">
            <span class="icon">✨</span>
            <span class="label">Fácil</span>
          </button>
        </div>
      </div>
    </div>

    <div v-if="showCompletionModal" class="modal-overlay">
      <div class="modal-card">
        <div class="modal-icon">🎉</div>
        <h2>Estudo Concluído!</h2>
        <p>Esse card foi respondido e seu progresso já foi computado no banco de dados.</p>
        
        <div class="session-stats">
          <div class="stat-item text-red">
            <span class="count">{{ stats.hard }}</span>
            <span class="desc">Erros</span>
          </div>
          <div class="stat-item text-green">
            <span class="count">{{ stats.good + stats.easy }}</span>
            <span class="desc">Acertos</span>
          </div>
        </div>

        <div class="modal-actions">
          <button class="btn-modal-secondary" @click="studyAgain">Estudar Novamente</button>
          <button class="btn-modal-primary" @click="goBack">Voltar para Decks</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useFlashcardStudy } from './FlashcardStudy'

const {
  flashcard,
  loading,
  isFlipped,
  showCompletionModal,
  stats,
  goBack,
  flipCard,
  rateCard,
  studyAgain,
  getLevelClass,
  getLevelText,
} = useFlashcardStudy()
</script>

<style scoped>
.flashcard-study-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  min-height: 100vh;
  background-color: #f8fafc;
  padding: 24px;
  box-sizing: border-box;
}

.study-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 100%;
  max-width: 560px;
  margin-bottom: 32px;
}

.btn-back {
  display: flex;
  align-items: center;
  gap: 8px;
  background: none;
  border: none;
  color: #64748b;
  font-size: 15px;
  font-weight: 500;
  cursor: pointer;
  transition: color 0.2s;
}

.btn-back:hover {
  color: #1e293b;
}

.badge {
  padding: 6px 12px;
  border-radius: 9999px;
  font-size: 13px;
  font-weight: 600;
}

.level-beginner { background-color: #dcfce7; color: #166534; }
.level-intermediate { background-color: #fef3c7; color: #92400e; }
.level-advanced { background-color: #fee2e2; color: #991b1b; }

.loading-state {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  margin-top: 100px;
  color: #64748b;
}

.spinner {
  width: 40px;
  height: 40px;
  border: 4px solid #e2e8f0;
  border-top-color: #4f46e5;
  border-radius: 50%;
  animation: spin 1s linear infinite;
  margin-bottom: 16px;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

.study-body {
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 100%;
  max-width: 560px;
  gap: 24px;
}

.flashcard-wrapper {
  width: 100%;
  height: 340px;
  perspective: 1000px;
  cursor: pointer;
}

.flashcard-inner {
  position: relative;
  width: 100%;
  height: 100%;
  text-align: center;
  transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
  transform-style: preserve-3d;
}

.flashcard-wrapper.flipped .flashcard-inner {
  transform: rotateY(180deg);
}

.flashcard-face {
  position: absolute;
  width: 100%;
  height: 100%;
  backface-visibility: hidden;
  border-radius: 16px;
  background-color: #ffffff;
  box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
  border: 1px solid #e2e8f0;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  padding: 24px;
  box-sizing: border-box;
}

.flashcard-back {
  transform: rotateY(180deg);
  background-color: #fafafa;
}

.indicator-tag {
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 1.2px;
  padding: 4px 8px;
  border-radius: 4px;
}

.indicator-tag.question { background-color: #eff6ff; color: #2563eb; }
.indicator-tag.answer { background-color: #f0fdf4; color: #16a34a; }

.face-content {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-grow: 1;
  padding: 0 16px;
}

.text-display {
  font-size: 20px;
  font-weight: 600;
  color: #1e293b;
  line-height: 1.5;
  margin: 0;
}

.hint-text {
  font-size: 13px;
  color: #94a3b8;
}

.action-dock {
  width: 100%;
  opacity: 0;
  transform: translateY(10px);
  transition: all 0.3s ease;
  pointer-events: none;
  text-align: center;
}

.action-dock.visible {
  opacity: 1;
  transform: translateY(0);
  pointer-events: auto;
}

.dock-title {
  font-size: 14px;
  font-weight: 500;
  color: #64748b;
  margin-bottom: 12px;
}

.dock-buttons {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 12px;
  width: 100%;
}

.btn-rate {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 6px;
  padding: 12px;
  border-radius: 12px;
  border: 1px solid #e2e8f0;
  background-color: white;
  cursor: pointer;
  transition: all 0.2s ease;
}

.btn-rate .icon { font-size: 20px; }
.btn-rate .label { font-size: 14px; font-weight: 600; }

.rate-hard { color: #dc2626; }
.rate-hard:hover { background-color: #fef2f2; border-color: #fca5a5; }

.rate-good { color: #d97706; }
.rate-good:hover { background-color: #fffbeb; border-color: #fde68a; }

.rate-easy { color: #16a34a; }
.rate-easy:hover { background-color: #f0fdf4; border-color: #bbf7d0; }

.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(15, 23, 42, 0.6);
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 16px;
  z-index: 50;
}

.modal-card {
  background-color: white;
  border-radius: 20px;
  padding: 32px;
  width: 100%;
  max-width: 440px;
  text-align: center;
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

.modal-icon {
  font-size: 48px;
  margin-bottom: 16px;
}

.modal-card h2 {
  font-size: 24px;
  color: #1e293b;
  margin: 0 0 8px 0;
}

.modal-card p {
  color: #64748b;
  font-size: 15px;
  line-height: 1.5;
  margin: 0 0 24px 0;
}

.session-stats {
  display: flex;
  justify-content: center;
  gap: 40px;
  background-color: #f8fafc;
  padding: 16px;
  border-radius: 12px;
  margin-bottom: 28px;
}

.stat-item {
  display: flex;
  flex-direction: column;
}

.stat-item .count {
  font-size: 24px;
  font-weight: 700;
}

.stat-item .desc {
  font-size: 13px;
  font-weight: 500;
  color: #94a3b8;
}

.text-red .count { color: #ef4444; }
.text-green .count { color: #22c55e; }

.modal-actions {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.btn-modal-primary {
  background-color: #4f46e5;
  color: white;
  border: none;
  padding: 14px;
  border-radius: 12px;
  font-size: 16px;
  font-weight: 600;
  cursor: pointer;
  transition: background-color 0.2s;
}

.btn-modal-primary:hover { background-color: #4338ca; }

.btn-modal-secondary {
  background: none;
  border: 1px solid #cbd5e1;
  color: #475569;
  padding: 14px;
  border-radius: 12px;
  font-size: 16px;
  font-weight: 600;
  cursor: pointer;
  transition: background-color 0.2s;
}

.btn-modal-secondary:hover { background-color: #f8fafc; }
</style>