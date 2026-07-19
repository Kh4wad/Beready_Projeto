// src/modules/admin/views/AdminPanel.ts
import { ref, computed, onMounted } from 'vue'
import { useAuth } from '@/shared/composables/useAuth'
import { useAlert } from '@/shared/composables/useAlert'
import api from '@/core/services/api'

export function useAdminPanel() {
  const { user } = useAuth()
  const { success, error } = useAlert()
  const activeTab = ref('users')
  const users = ref<any[]>([])
  const loadingUsers = ref(false)
  const updatingRole = ref<number | null>(null)
  const searchQuery = ref('')
  const stats = ref({
    total_users: 0,
    total_flashcards: 0,
    total_quizes: 0,
    total_prompts: 0,
  })

  const currentUserId = computed(() => user.value?.id)

  const filteredUsers = computed(() => {
    if (!searchQuery.value) return users.value
    const query = searchQuery.value.toLowerCase()
    return users.value.filter(
      (u) => u.nome?.toLowerCase().includes(query) || u.email?.toLowerCase().includes(query),
    )
  })

  const loadUsers = async () => {
    loadingUsers.value = true
    try {
      const response = await api.get('/admin/users')

      let data = response.data
      if (typeof data === 'string') {
        try {
          data = JSON.parse(data)
        } catch (e) {
          console.error('Erro ao fazer parse da resposta:', e)
        }
      }

      if (data && data.success) {
        users.value = data.data || []
      } else {
        console.error('Erro na resposta:', data?.message)
        users.value = []
      }
    } catch (err) {
      console.error('Erro ao carregar usuários:', err)
      users.value = []
    } finally {
      loadingUsers.value = false
    }
  }

  const loadStats = async () => {
    try {
      const response = await api.get('/admin/stats')
      if (response.data.success) {
        stats.value = response.data.data
      }
    } catch (err) {
      console.error('Erro ao carregar estatísticas:', err)
    }
  }

  const toggleRole = async (targetUser: any) => {
    const newRole = targetUser.role === 'admin' ? 'user' : 'admin'

    updatingRole.value = targetUser.id

    try {
      const response = await api.post('/admin/users/role', {
        user_id: targetUser.id,
        role: newRole,
      })

      if (response.data.success) {
        await loadUsers()
        success(
          `${targetUser.nome} ${newRole === 'admin' ? 'agora é Administrador' : 'agora é Usuário'}`,
        )
      } else {
        error(response.data.message || 'Erro ao alterar permissão')
      }
    } catch (err: any) {
      console.error('Erro:', err)
      error(err.response?.data?.message || 'Erro ao alterar permissão')
    } finally {
      updatingRole.value = null
    }
  }

  onMounted(() => {
    loadUsers()
    loadStats()
  })

  return {
    user,
    activeTab,
    users,
    loadingUsers,
    updatingRole,
    searchQuery,
    stats,
    currentUserId,
    filteredUsers,
    toggleRole,
  }
}
