import { useEffect } from 'react';
import { useQueryClient } from '@tanstack/react-query';
import { echoClient } from '@/shared/realtime/echoClient';
import type { Call } from '@/features/calls/types';
import { CALLS_QUERY_KEYS } from '@/features/calls/constants';
import { ApiResponse } from '@/shared/types/response.types';
import playNotificationSound from '@/shared/utils/audioNotification';

export function useCallsRealtime() {

    const queryClient = useQueryClient();

    useEffect(() => {

        // Subcripcion al channel de reverb
        const channel = echoClient.channel('calls-channel');

        // Escuchar evento de llamada entrante
        channel.listen('.CallReceivedEvent', () => {
            playNotificationSound();
            queryClient.invalidateQueries({ queryKey: CALLS_QUERY_KEYS });
        });

        return () => echoClient.leaveChannel('calls-channel');

    }, [queryClient]);

}