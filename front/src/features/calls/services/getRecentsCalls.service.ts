import { httpClient } from "@/shared/api/httpClient";
import { ApiResponse } from "@/shared/types";
import { Call } from "@/features/calls/types";

export const getRecentsCalls = async (): Promise<ApiResponse<Call[]>> => {
    const response = await httpClient.get<ApiResponse<Call[]>>('/recents-calls');
    return response.data;
}
