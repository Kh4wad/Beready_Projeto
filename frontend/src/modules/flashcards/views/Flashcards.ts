// src/modules/flashcards/views/Flashcards.ts

import { ref, reactive, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useFlashcards } from '../composables/useFlashcards'
import type { Flashcard, User } from '@/core/types'

interface FormData {
  frente: string
  verso: string
  nivel_dificuldade: string
}

export function useFlashcardsView() {
  const router = useRouter()
  const { flashcards, loading, loadFlashcards, createFlashcard, updateFlashcard, deleteFlashcard } =
    useFlashcards()

  const showModal = ref(false)
  const showDeleteModal = ref(false)
  const isEditing = ref(false)
  const editingId = ref<number | null>(null)
  const deletingFlashcard = ref<Flashcard | null>(null)
  const submitting = ref(false)
  const deleting = ref(false)

  const form = reactive<FormData>({
    frente: '',
    verso: '',
    nivel_dificuldade: 'medio',
  })

  const resetForm = (): void => {
    form.frente = ''
    form.verso = ''
    form.nivel_dificuldade = 'medio'
    editingId.value = null
    isEditing.value = false
  }

  const openCreateModal = (): void => {
    resetForm()
    isEditing.value = false
    showModal.value = true
  }

  const openEditModal = (flashcard: Flashcard): void => {
    form.frente = flashcard.frente
    form.verso = flashcard.verso
    form.nivel_dificuldade = flashcard.nivel_dificuldade || 'medio'
    editingId.value = flashcard.id
    isEditing.value = true
    showModal.value = true
  }

  const viewFlashcard = (id: number): void => {
    router.push(`/flashcards/${id}`)
  }

  const studyFlashcard = (id: number): void => {
    router.push(`/flashcards/${id}/study`)
  }

  const confirmDelete = (flashcard: Flashcard): void => {
    deletingFlashcard.value = flashcard
    showDeleteModal.value = true
  }

  const handleDelete = async (): Promise<void> => {
    if (!deletingFlashcard.value) return
    deleting.value = true
    try {
      await deleteFlashcard(deletingFlashcard.value.id)
      showDeleteModal.value = false
      const userData = localStorage.getItem('user')
      if (userData) {
        const user = JSON.parse(userData) as User
        await loadFlashcards(user.id)
      }
    } finally {
      deleting.value = false
      deletingFlashcard.value = null
    }
  }

  const submitForm = async (): Promise<void> => {
    const userData = localStorage.getItem('user')
    if (!userData) return

    let user: User
    try {
      user = JSON.parse(userData) as User
    } catch (e) {
      console.error('Erro ao fazer parse do userData:', e)
      return
    }

    submitting.value = true

    try {
      const data = {
        usuario_id: user.id,
        frente: form.frente,
        verso: form.verso,
        nivel_dificuldade: form.nivel_dificuldade,
      }

      if (isEditing.value && editingId.value) {
        await updateFlashcard(editingId.value, data)
      } else {
        await createFlashcard(data)
      }

      closeModal()
      await loadFlashcards(user.id)
    } finally {
      submitting.value = false
    }
  }

  const closeModal = (): void => {
    showModal.value = false
    resetForm()
  }

  const getUserFromLocalStorage = (): User | null => {
    const userData = localStorage.getItem('user')
    if (!userData) return null
    try {
      return JSON.parse(userData) as User
    } catch {
      return null
    }
  }

  onMounted(async () => {
    const user = getUserFromLocalStorage()
    if (user?.id) {
      await loadFlashcards(user.id)
    }
  })

  return {
    flashcards,
    loading,
    showModal,
    showDeleteModal,
    isEditing,
    editingId,
    deletingFlashcard,
    submitting,
    deleting,
    form,
    openCreateModal,
    openEditModal,
    viewFlashcard,
    studyFlashcard,
    confirmDelete,
    handleDelete,
    submitForm,
    closeModal,
  }
}
