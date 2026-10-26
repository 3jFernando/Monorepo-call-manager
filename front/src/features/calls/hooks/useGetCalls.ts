import { useQuery, keepPreviousData } from '@tanstack/react-query';
import { CALLS_QUERY_KEYS } from '@/features/calls/constants';
import { getCalls } from '@/features/calls/services';

export function useGetCalls(page = 1, perPage = 10) {
    return useQuery({
        queryKey: [...CALLS_QUERY_KEYS, page, perPage],
        queryFn: () => getCalls(page, perPage),          
        placeholderData: keepPreviousData
    });
}