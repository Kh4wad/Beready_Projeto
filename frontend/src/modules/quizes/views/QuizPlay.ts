import { respostaService } from '@/modules/progresso/services/respostaService'
import { computed, onMounted, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { API_BASE_URL } from '@/shared/config/env'

export function useQuizPlay() {
  const route = useRoute()
  const router = useRouter()

  const quizId = Number(route.params.id)

  const questoes = ref<any[]>([])
  const currentQuestionIndex = ref(0)
  const selectedAlternativaId = ref<number | null>(null)
  const respondido = ref(false)
  const loading = ref(true)

  // Início da sessão
  const sessionStartTime = ref(Date.now())

  const getUsuarioId = () => {
    const userData = localStorage.getItem('user')

    if (!userData) return null

    try {
      return JSON.parse(userData).id
    } catch {
      return null
    }
  }

  const currentQuestao = computed(
    () => questoes.value[currentQuestionIndex.value] || null
  )

  const isFinished = computed(
    () =>
      questoes.value.length > 0 &&
      currentQuestionIndex.value >= questoes.value.length
  )

  const loadQuizQuestoes = async () => {
    try {
      loading.value = true

      // Simulação das questões
      questoes.value = [
        {
          id: 501,
          enunciado:
            'Qual princípio do SOLID foca em interfaces específicas em vez de uma genérica?',
          alternativas: [
            {
              id: 1,
              texto: 'Single Responsibility Principle',
              correta: false,
            },
            {
              id: 2,
              texto: 'Interface Segregation Principle',
              correta: true,
            },
            {
              id: 3,
              texto: 'Dependency Inversion Principle',
              correta: false,
            },
          ],
        },
        {
          id: 502,
          enunciado:
            'No CakePHP, qual camada é responsável por conter a lógica de negócios e ORM?',
          alternativas: [
            {
              id: 4,
              texto: 'Controller',
              correta: false,
            },
            {
              id: 5,
              texto: 'View',
              correta: false,
            },
            {
              id: 6,
              texto: 'Model / Table',
              correta: true,
            },
          ],
        },
      ]
    } catch (err) {
      console.error('Erro ao carregar questões do quiz:', err)
    } finally {
      loading.value = false
    }
  }

  const incrementarTempo = async () => {
    const usuarioId = getUsuarioId()

    if (!usuarioId) return

    const segundos = Math.floor(
      (Date.now() - sessionStartTime.value) / 1000
    )

    if (segundos <= 0) return

    try {
      await fetch(`${API_BASE_URL}/progresso/incrementar-tempo`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          Accept: 'application/json',
        },
        body: JSON.stringify({
          usuario_id: usuarioId,
          segundos,
        }),
      })
    } catch (err) {
      console.error('Erro ao salvar tempo do quiz:', err)
    }
  }

  const verificarResposta = async () => {
    if (
      selectedAlternativaId.value === null ||
      !currentQuestao.value
    ) {
      return
    }

    const usuarioId = getUsuarioId()

    if (!usuarioId) return

    const alternativa = currentQuestao.value.alternativas.find(
      (a: any) => a.id === selectedAlternativaId.value
    )

    const acertou = alternativa ? alternativa.correta : false

    respondido.value = true

    try {
      await respostaService.registrarResposta({
        usuario_id: usuarioId,
        tipo: 'quiz',
        referencia_id: quizId,
        correto: acertou,
      })
    } catch (err) {
      console.warn('Erro ao salvar resposta do quiz:', err)
    }
  }

  const avançar = async () => {
    currentQuestionIndex.value++

    // Terminou o quiz
    if (currentQuestionIndex.value >= questoes.value.length) {
      await incrementarTempo()
      return
    }

    selectedAlternativaId.value = null
    respondido.value = false
  }

  onMounted(() => {
    sessionStartTime.value = Date.now()
    loadQuizQuestoes()
  })

  return {
    currentQuestao,
    currentQuestionIndex,
    selectedAlternativaId,
    respondido,
    loading,
    isFinished,
    totalQuestoes: computed(() => questoes.value.length),
    verificarResposta,
    avançar,
    voltar: () => router.back(),
  }
}