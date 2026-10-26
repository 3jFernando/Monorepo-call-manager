import { httpClient } from "@/shared/api/httpClient";
import { ApiResponse } from "@/shared/types";
import { dashboardData } from "@/features/calls/types";

export const getDashboardData = async (): Promise<ApiResponse<dashboardData>> => {
    const response = await httpClient.get<ApiResponse<dashboardData>>('/calls/dashboard');
    return response.data;
}
