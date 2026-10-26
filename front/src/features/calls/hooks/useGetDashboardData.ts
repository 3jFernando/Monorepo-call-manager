import { useQuery } from '@tanstack/react-query';
import { CALLS_QUERY_KEYS } from '@/features/calls/constants';
import { getDashboardData } from '@/features/calls/services';
import { ApiResponse } from '@/shared/types';
import { dashboardData } from '../types';

export function useGetDashboardData() {
    return useQuery({
        queryKey: [...CALLS_QUERY_KEYS, 'dashboard'],
        queryFn: () => getDashboardData(),
        select: (response: ApiResponse<dashboardData>) => response ? response?.data  : null
    });
}