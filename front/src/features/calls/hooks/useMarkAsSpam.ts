import { useMutation, useQueryClient } from '@tanstack/react-query';
import { markCallAsSpam } from '@/features/calls/services';
import { CALLS_QUERY_KEYS } from '@/features/calls/constants';

export function useMarkAsSpam() {
    const queryClient = useQueryClient();

    return useMutation({
        mutationFn: (callId: string) => markCallAsSpam(callId),
        onSuccess: () => queryClient.invalidateQueries({ queryKey: CALLS_QUERY_KEYS })
    });
}
