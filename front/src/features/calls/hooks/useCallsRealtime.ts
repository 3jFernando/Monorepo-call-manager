import { useEffect } from 'react';
import { useQueryClient } from '@tanstack/react-query';
import { echoClient } from '@/shared/realtime/echoClient';
import type { Call } from '@/features/calls/types';
import { CALLS_QUERY_KEYS } from '@/features/calls/constants';
import { ApiResponse } from '@/shared/types/response.types';

export function useCallsRealtime() {

    const queryClient = useQueryClient();

    useEffect(() => {

        // Subcripcion al channel de reverb
        const channel = echoClient.channel('calls-channel');

        // Escuchar evento de llamada entrante
        channel.listen('.CallReceivedEvent', (payload: { call: Call }) => {

           queryClient.setQueryData(CALLS_QUERY_KEYS, (currentCalls: ApiResponse<Call[]>| undefined) => {   

                const currentList = Array.isArray(currentCalls)
                    ? currentCalls
                    : (currentCalls?.data ?? []);
            
                if (!currentList) return { data: [payload.call] }

                const search = currentList.some((call: Call) => call.call_id === payload.call.call_id)
                if (search) return currentCalls

                return {
                    ...currentCalls, data: [ payload.call, ...currentList ]
                }

           });

        });

        return () => echoClient.leaveChannel('calls-channel');

    }, [queryClient]);

}