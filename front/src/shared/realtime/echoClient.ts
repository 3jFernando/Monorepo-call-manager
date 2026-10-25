import Echo from 'laravel-echo'
import Pusher from 'pusher-js'
import { ENV } from "@/config/env"

// Asignar a scope de window porar disponibilidad
(window as any).Pusher = Pusher;

export const echoClient = new Echo({
    broadcaster: 'reverb',
    key: ENV.REVERB_APP_KEY,
    wsHost: ENV.REVERB_HOST,
    wsPort: ENV.REVERB_PORT,
    wssPort: ENV.REVERB_PORT,
    forceTLS: ENV.REVERB_SCHEME === 'https',    
    anabledTransports: ['ws', 'wss']
})