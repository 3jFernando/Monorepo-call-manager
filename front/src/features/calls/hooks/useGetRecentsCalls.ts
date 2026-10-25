import { useQuery } from '@tanstack/react-query';
import { CALLS_QUERY_KEYS } from '@/features/calls/constants';
import { getRecentsCalls } from '@/features/calls/services';

export function useGetRecentsCalls() {
    return useQuery({
        queryKey: CALLS_QUERY_KEYS,
        queryFn: () => getRecentsCalls(),
        select: (response) => response.data
    });
}