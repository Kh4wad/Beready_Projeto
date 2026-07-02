import { ref, computed, onMounted, watch } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useAlert } from '@/shared/composables/useAlert'
import { API_BASE_URL } from '@/shared/config/env'
import { respostaService } from '@/modules/progresso/services/respostaService'

export function useFlashcardStudy() {
  const router = useRouter()
  const route = useRoute()
  const { error } = useAlert()
  const flashcards = ref<any[]>([])
  const currentIndex = ref(0)
  const loading = ref(true)
  const isFlipped = ref(false)
  const showCompletionModal = ref(false)
  const stats = ref({ hard: 0, good: 0, easy: 0 })
  const allFlashcardIds = ref<number[]>([])
  const hasNextFlashcard = ref(false)

  const currentFlashcard = computed(() => flashcards.value[currentIndex.value])
  const flashcard = computed(() => currentFlashcard.value)

  const loadAllFlashcardIds = async () => {
    try {
      const response = await fetch(`${API_BASE_URL}/flashcards`, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          Accept: 'application/json',
        },
      })
      const data = await response.json()
      if (data.success && Array.isArray(data.data)) {
        allFlashcardIds.value = data.data.map((item: any) => Number(item.id))
      }
    } catch (err) {
      console.error('Erro ao carregar lista de flashcards:', err)
    }
  }

  const updateHasNextFlashcard = () => {
    const currentId = Number(route.params.id)
    const idx = allFlashcardIds.value.indexOf(currentId)
    hasNextFlashcard.value = idx !== -1 && idx < allFlashcardIds.value.length - 1
  }

  const loadFlashcards = async () => {
    const id = route.params.id
    if (!id) {
      error('ID do flashcard não informado')
      router.push('/flashcards')
      return
    }

    loading.value = true
    try {
      const response = await fetch(`${API_BASE_URL}/flashcards/${id}`, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          Accept: 'application/json',
        },
      })

      const data = await response.json()

      if (data.success) {
        const item = data.data
        flashcards.value = [{
          id: item.id,
          pergunta: item.pergunta || item.frente || '',
          resposta: item.resposta || item.verso || '',
          nivel_dificuldade: item.nivel_dificuldade || item.dificuldade || 'iniciante'
        }]
        currentIndex.value = 0
        updateHasNextFlashcard()
      } else {
        error(data.message || 'Erro ao carregar flashcard')
        router.push('/flashcards')
      }
    } catch (err) {
      console.error('Erro:', err)
      error('Erro de conexão com o servidor')
      router.push('/flashcards')
    } finally {
      loading.value = false
    }
  }

  const goBack = () => {
    router.push('/flashcards')
  }

  const flipCard = () => {
    isFlipped.value = !isFlipped.value
  }

  const nextCard = () => {
    if (currentIndex.value < flashcards.value.length - 1) {
      currentIndex.value++
      isFlipped.value = false
    }
  }

  const previousCard = () => {
    if (currentIndex.value > 0) {
      currentIndex.value--
      isFlipped.value = false
    }
  }

  const goToNextFlashcard = () => {
    const currentId = Number(route.params.id)
    const idx = allFlashcardIds.value.indexOf(currentId)

    if (idx === -1 || idx >= allFlashcardIds.value.length - 1) {
      error('Não há mais flashcards para estudar.')
      return
    }

    const nextId = allFlashcardIds.value[idx + 1]
    showCompletionModal.value = false
    isFlipped.value = false
    router.push({ name: route.name as string, params: { id: nextId } })
  }

  const incrementarProgresso = async (usuarioId: number) => {
    try {
      await fetch(`${API_BASE_URL}/progresso/incrementar-flashcards`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          Accept: 'application/json',
        },
        body: JSON.stringify({
          usuario_id: usuarioId,
          quantidade: 1
        })
      })
    } catch (err) {
      console.error('Erro ao incrementar progresso:', err)
    }
  }

  const rateCard = async (rating: 'hard' | 'good' | 'easy') => {
    if (rating === 'hard') stats.value.hard++
    if (rating === 'good') stats.value.good++
    if (rating === 'easy') stats.value.easy++

    const userData = localStorage.getItem('user')
    if (userData && currentFlashcard.value) {
      try {
        const localUser = JSON.parse(userData)
        const isCorrect = rating !== 'hard'

        respostaService.registrarResposta({
          usuario_id: Number(localUser.id),
          tipo: 'flashcard',
          referencia_id: currentFlashcard.value.id,
          correto: isCorrect
        }).catch(err => {
          console.warn('Falha ao registrar resposta no banco:', err)
        })

        incrementarProgresso(Number(localUser.id))
      } catch (e) {
        console.error('Erro ao processar dados do usuário para o progresso:', e)
      }
    }

    if (currentIndex.value < flashcards.value.length - 1) {
      nextCard()
    } else {
      finishStudy()
    }
  }

  const finishStudy = () => {
    showCompletionModal.value = true
  }

  const studyAgain = () => {
    showCompletionModal.value = false
    currentIndex.value = 0
    isFlipped.value = false
    stats.value = { hard: 0, good: 0, easy: 0 }
  }

  const getLevelClass = (level: string) => {
    const normalized = String(level).toLowerCase()
    const classes: Record<string, string> = {
      iniciante: 'level-beginner',
      medio: 'level-intermediate',
      intermediario: 'level-intermediate',
      avancado: 'level-advanced',
    }
    return classes[normalized] || 'level-beginner'
  }

  const getLevelText = (level: string) => {
    const normalized = String(level).toLowerCase()
    const texts: Record<string, string> = {
      iniciante: 'Iniciante',
      medio: 'Intermediário',
      intermediario: 'Intermediário',
      avancado: 'Avançado',
    }
    return texts[normalized] || level
  }

  watch(
    () => route.params.id,
    () => {
      stats.value = { hard: 0, good: 0, easy: 0 }
      loadFlashcards()
    }
  )

  onMounted(() => {
    loadAllFlashcardIds()
    loadFlashcards()
  })

  return {
    flashcard,
    flashcards,
    currentIndex,
    currentFlashcard,
    loading,
    isFlipped,
    showCompletionModal,
    stats,
    hasNextFlashcard,
    goBack,
    flipCard,
    nextCard,
    previousCard,
    rateCard,
    finishStudy,
    studyAgain,
    goToNextFlashcard,
    getLevelClass,
    getLevelText,
  }
}