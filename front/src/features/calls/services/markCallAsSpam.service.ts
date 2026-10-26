import { httpClient } from '@/shared/api/httpClient';
import { ApiResponse } from '@/shared/types/response.types';
import { Call } from '@/features/calls/types';

export const markCallAsSpam = async (callId: string): Promise<ApiResponse<Call>> => {
    const response = await httpClient.patch<ApiResponse<Call>>(`/calls/${callId}/spam`);
    return response.data;
};
