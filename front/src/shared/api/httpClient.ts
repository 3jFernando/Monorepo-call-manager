import axios from 'axios'

import { ENV } from '@/config/env'

export const httpClient = axios.create({
    baseURL: ENV.API_BASE_URL,
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    },
    timeout: 10000
});