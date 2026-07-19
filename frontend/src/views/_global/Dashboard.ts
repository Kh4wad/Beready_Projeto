// src/views/_global/Dashboard.ts

import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/core/services/api'
import axios from 'axios'
import { useI18n } from 'vue-i18n'

export function useDashboard() {
  const router = useRouter()
  const { t } = useI18n()
  const user = ref<any>(null)
  const loading = ref(false)
  const stats = ref({
    flashcardsCount: 0,
    acertoRate: 0,
    sequenciaAtual: 0,
    tempoEstudo: '0min',
    progressoGeral: 0,
  })

  const userName = computed(() => {
    if (user.value?.nome) {
      return user.value.nome.split(' ')[0]
    }
    return t('common.usuario')
  })

  const motivationalMessage = computed(() => {
    if (stats.value.sequenciaAtual >= 7) {
      return `🔥 ${t('dashboard.motivacional.alta', { dias: stats.value.sequenciaAtual })}`
    }
    if (stats.value.sequenciaAtual >= 3) {
      return `📈 ${t('dashboard.motivacional.media', { dias: stats.value.sequenciaAtual })}`
    }
    return t('dashboard.motivacional.padrao')
  })

  const formatTempoEstudo = (totalSegundos: number): string => {
    if (totalSegundos <= 0) {
      return '0 s'
    }

    if (totalSegundos < 60) {
      return `${totalSegundos} s`
    }

    const minutos = Math.floor(totalSegundos / 60)

    if (minutos < 60) {
      return `${minutos} min`
    }

    const horas = Math.floor(minutos / 60)
    const minutosRestantes = minutos % 60

    if (minutosRestantes === 0) {
      return `${horas} h`
    }

    return `${horas} h ${minutosRestantes} min`
  }

  const loadUserData = async () => {
    const userData = localStorage.getItem('user')
    if (!userData) return

    loading.value = true
    try {
      user.value = JSON.parse(userData)
      const response = await api.get(`/progresso/usuario/${user.value.id}`)

      if (response.data && response.data.data) {
        const data = response.data.data

        stats.value.flashcardsCount =
          data.total_flashcards_estudados ||
          data.flashcards_concluidos ||
          data.total_estudados ||
          data.flashcards_count ||
          data.total ||
          0

        stats.value.sequenciaAtual =
          data.sequencia_dias || data.sequencia_atual || data.sequencia || 0

        const totalSegundos = data.tempo_total_estudo || 0
        stats.value.tempoEstudo = formatTempoEstudo(totalSegundos)

        stats.value.acertoRate = data.taxa_acerto ?? data.acerto_rate ?? 0
        stats.value.progressoGeral = Math.min(100, data.progresso_geral ?? data.taxa_acerto ?? 0)
      }
    } catch (err: any) {
      console.error('Erro ao carregar estatisticas:', err)

      if (axios.isAxiosError(err) && err.response?.status === 401) {
        router.push('/login')
      }
    } finally {
      loading.value = false
    }
  }

  const handleLogout = () => {
    localStorage.removeItem('user')
    localStorage.removeItem('access_token')
    localStorage.removeItem('refresh_token')
    router.push('/login')
  }

  onMounted(() => {
    loadUserData()
  })

  return {
    user,
    loading,
    userName,
    stats,
    motivationalMessage,
    handleLogout,
    formatTempoEstudo,
  }
}
