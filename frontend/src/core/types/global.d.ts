// src/types/global.d.ts
export {}

declare global {
  interface Window {
    grecaptcha: {
      execute: (siteKey: string, options: { action: string }) => Promise<string>
      ready: (callback: () => void) => void
      render: (container: string | HTMLElement, parameters: Record<string, unknown>) => number
      reset: (optWidgetId?: number) => void
      getResponse: (optWidgetId?: number) => string
    }
  }
}
