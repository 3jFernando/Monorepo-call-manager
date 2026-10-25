export const ENV = {
    API_BASE_URL: import.meta.env.VITE_API_URL,
    REVERB_APP_KEY: import.meta.env.VITE_REVERB_APP_KEY,
    REVERB_HOST: import.meta.env.VITE_REVERB_HOST,
    REVERB_PORT: Number(import.meta.env.VITE_REVERB_PORT),
    REVERB_SCHEME: import.meta.env.VITE_REVERB_SCHEME
} as const;