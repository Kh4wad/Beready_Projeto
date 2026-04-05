import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useAlert } from '@/composables/useAlert'

export function useQuizes() {
  const router = useRouter()
  const { success, error } = useAlert()
  const quizes = ref<any[]>([])
  const loading = ref(true)
  const creating = ref(false)
  const deleting = ref(false)
  const editing = ref(false)
  const showCreateModal = ref(false)
  const showEditModal = ref(false)
  const showConfirmModal = ref(false)
  const quizToDeleteId = ref<number | null>(null)
  const quizToDeleteTitle = ref('')
  const selectedQuiz = ref<any>(null)
  
  const newQuiz = ref({
    titulo: '',
    descricao: '',
    nivel_dificuldade: 'iniciante',
    total_questoes: 0,
    tempo_limite: null,
    publico: false
  })

  const editForm = ref({
    id: null,
    titulo: '',
    descricao: '',
    nivel_dificuldade: 'iniciante',
    total_questoes: 0,
    tempo_limite: null,
    publico: false
  })

  const loadQuizes = async () => {
    loading.value = true
    try {
      const response = await fetch('http://localhost:8765/quizes', {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        }
      })
      
      const data = await response.json()
      
      if (data.success) {
        quizes.value = data.data
      } else {
        error(data.message || 'Erro ao carregar quizzes')
      }
    } catch (err) {
      console.error('Erro:', err)
      error('Erro de conexão com o servidor')
    } finally {
      loading.value = false
    }
  }

  const viewQuiz = (id: number) => {
    router.push(`/quizes/${id}`)
  }

  const startQuiz = (id: number) => {
    router.push(`/quizes/${id}/play`)
  }

  const editQuiz = (quiz: any) => {
    selectedQuiz.value = quiz
    editForm.value = {
      id: quiz.id,
      titulo: quiz.titulo,
      descricao: quiz.descricao || '',
      nivel_dificuldade: quiz.nivel_dificuldade || 'iniciante',
      total_questoes: quiz.total_questoes || 0,
      tempo_limite: quiz.tempo_limite || null,
      publico: quiz.publico || false
    }
    showEditModal.value = true
  }

  const updateQuiz = async () => {
    if (!editForm.value.titulo) {
      error('Título é obrigatório')
      return
    }

    editing.value = true
    try {
      const response = await fetch(`http://localhost:8765/quizes/${editForm.value.id}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        },
        body: JSON.stringify({
          titulo: editForm.value.titulo,
          descricao: editForm.value.descricao,
          nivel_dificuldade: editForm.value.nivel_dificuldade,
          total_questoes: editForm.value.total_questoes,
          tempo_limite: editForm.value.tempo_limite,
          publico: editForm.value.publico
        })
      })
      
      const data = await response.json()
      
      if (data.success) {
        success('Quiz atualizado com sucesso!')
        showEditModal.value = false
        loadQuizes()
      } else {
        error(data.message || 'Erro ao atualizar quiz')
      }
    } catch (err) {
      console.error('Erro:', err)
      error('Erro de conexão com o servidor')
    } finally {
      editing.value = false
    }
  }

  const openDeleteModal = (id: number, titulo: string) => {
    quizToDeleteId.value = id
    quizToDeleteTitle.value = titulo
    showConfirmModal.value = true
  }

  const confirmDelete = async () => {
    if (!quizToDeleteId.value) return
    
    deleting.value = true
    try {
      const response = await fetch(`http://localhost:8765/quizes/${quizToDeleteId.value}`, {
        method: 'DELETE',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        }
      })
      
      const data = await response.json()
      
      if (data.success) {
        success('Quiz excluído com sucesso!')
        showConfirmModal.value = false
        quizToDeleteId.value = null
        quizToDeleteTitle.value = ''
        loadQuizes()
      } else {
        error(data.message || 'Erro ao excluir quiz')
      }
    } catch (err) {
      console.error('Erro:', err)
      error('Erro de conexão com o servidor')
    } finally {
      deleting.value = false
    }
  }

  const createQuiz = async () => {
    if (!newQuiz.value.titulo) {
      error('Título é obrigatório')
      return
    }

    const userData = localStorage.getItem('user')
    if (!userData) {
      error('Usuário não autenticado')
      router.push('/login')
      return
    }

    const user = JSON.parse(userData)
    
    creating.value = true
    try {
      const response = await fetch('http://localhost:8765/quizes', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        },
        body: JSON.stringify({
          ...newQuiz.value,
          usuario_id: user.id
        })
      })
      
      const data = await response.json()
      
      if (data.success) {
        success('Quiz criado com sucesso!')
        showCreateModal.value = false
        newQuiz.value = {
          titulo: '',
          descricao: '',
          nivel_dificuldade: 'iniciante',
          total_questoes: 0,
          tempo_limite: null,
          publico: false
        }
        loadQuizes()
      } else {
        error(data.message || 'Erro ao criar quiz')
      }
    } catch (err) {
      console.error('Erro:', err)
      error('Erro de conexão com o servidor')
    } finally {
      creating.value = false
    }
  }

  const getLevelClass = (level: string) => {
    const classes: Record<string, string> = {
      iniciante: 'level-beginner',
      intermediario: 'level-intermediate',
      avancado: 'level-advanced'
    }
    return classes[level] || 'level-beginner'
  }

  const getLevelText = (level: string) => {
    const texts: Record<string, string> = {
      iniciante: 'Iniciante',
      intermediario: 'Intermediário',
      avancado: 'Avançado'
    }
    return texts[level] || level
  }

  const formatDate = (date: string) => {
    if (!date) return 'Data não informada'
    return new Date(date).toLocaleDateString('pt-BR')
  }

  onMounted(() => {
    loadQuizes()
  })

  return {
    quizes,
    loading,
    creating,
    deleting,
    editing,
    showCreateModal,
    showEditModal,
    showConfirmModal,
    quizToDeleteId,
    quizToDeleteTitle,
    newQuiz,
    editForm,
    viewQuiz,
    startQuiz,
    editQuiz,
    updateQuiz,
    openDeleteModal,
    confirmDelete,
    createQuiz,
    getLevelClass,
    getLevelText,
    formatDate
  }
}