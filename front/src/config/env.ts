export const ENV = {
    API_BASE_URL: (import.meta as any).env.VITE_API_URL || 'http://localhost:8000/api',
} as const;