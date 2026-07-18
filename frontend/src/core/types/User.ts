export interface User {
  id: number
  nome: string
  email: string
  role: 'user' | 'admin'
  telefone?: string
  nivel_ingles?: string
  idioma_preferido?: string
  objetivos_aprendizado?: string
  status?: string
  uuid?: string
  foto_perfil?: string
  senha_hash?: string
  criado_em?: string
  atualizado_em?: string
  ultimo_login?: string | null
}
