export function formatTempoEstudo(totalSegundos: number): string {
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