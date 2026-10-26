import { PaginatedData } from "@/shared/types/pagination.types";

export type ApiResponse<T> = {
    data: T;
    message: String;
}

export interface PaginatedApiResponse<T> {
  message: string;
  data: PaginatedData<T>;
}