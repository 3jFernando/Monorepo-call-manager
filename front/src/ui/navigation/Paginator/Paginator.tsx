import React from "react";
import { ChevronLeft, ChevronRight } from "lucide-react";
import { Button } from "@/ui";

interface Props {
  currentPage: number;
  lastPage: number;  
  onPageChange: (page: number) => void;
  isLoading: boolean;
}

export default function Paginator({
  currentPage,
  lastPage,
  onPageChange,
  isLoading,
}: Props) {
  return (
    <div className="flex justify-end items-center mt-4 pt-3 border-t border-gray-200 text-sm">      
      <div className="flex items-center gap-2">
        <span className="text-gray-500 text-xs">
          Página {currentPage} de {lastPage}
        </span>
        <div className="flex items-center gap-2">
          <Button
            onClick={() => onPageChange(currentPage - 1)}
            disabled={currentPage <= 1 || isLoading}
          >
            <ChevronLeft size={14} /> Anterior
          </Button>
          <Button
            onClick={() => onPageChange(currentPage + 1)}
            disabled={currentPage >= lastPage || isLoading}
          >
            Siguiente <ChevronRight size={14} />
          </Button>
        </div>
      </div>
    </div>
  );
}
