import { computed } from 'vue'
import type { User } from '@/core/types/User'

interface NavbarProps {
  user: User | null
  loading: boolean
}

export function useNavbar(props: NavbarProps) {
  const userName = computed(() => props.user?.nome || 'Usuário')
  const userEmail = computed(() => props.user?.email || '')
  const userInitial = computed(() => userName.value.charAt(0).toUpperCase())

  const menuItems = [
    { name: 'Dashboard', path: '/dashboard', icon: 'HomeIcon' },
    { name: 'Perfil', path: '/profile', icon: 'UserIcon' },
    { name: 'Flashcards', path: '/flashcards', icon: 'DocumentIcon' },
    { name: 'Quizes', path: '/quizes', icon: 'ClipboardIcon' },
    { name: 'Prompts IA', path: '/prompts', icon: 'ChatIcon' },
    { name: 'Tags', path: '/tags', icon: 'TagIcon' },
    { name: 'Progresso', path: '/progresso', icon: 'ChartIcon' },
    { name: 'Preferências', path: '/preferencias', icon: 'SettingsIcon' },
  ]

  return {
    userName,
    userEmail,
    userInitial,
    menuItems,
  }
}
