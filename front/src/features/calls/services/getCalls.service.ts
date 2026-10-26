import { httpClient } from "@/shared/api/httpClient";
import { PaginatedApiResponse } from "@/shared/types";
import { Call } from "@/features/calls/types";

export const getCalls = async (page = 1, perPage = 10): Promise<PaginatedApiResponse<Call[]>> => {
    const response = await httpClient.get<PaginatedApiResponse<Call[]>>('/calls', {
        params: { page, perPage }
    });
    return response.data.data;
}
