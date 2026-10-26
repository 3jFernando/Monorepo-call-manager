import React, { useState } from "react";

import { Phone, SquareActivity, UserRoundCheck, Megaphone } from "lucide-react";

import CallList from "@/features/calls/components/List/CallList";
import { useCallsRealtime, useGetCalls } from "@/features/calls/hooks";
import CardHeader from "@/features/calls/components/fragments/CardHeader";
import useFilterCallsToHeader from "@/features/calls/hooks/useFilterCallsToHeader";

const PER_PAGE = 10;

export default function Home() {
  useCallsRealtime();

  const [page, setPage] = useState(1);

  const { data: paginatedData, isLoading } = useGetCalls(page, PER_PAGE);
  const calls = paginatedData?.data ?? [];

  const { last10Minutes, spamCount, top3Agents, totalCalls } = useFilterCallsToHeader();  

  return (
    <div className="flex flex-col">
      <div className="grid grid-cols-1 sm:grid-cols-4 gap-2 mb-4">
        <CardHeader
          title="RECIENTES"
          icon={<Phone size={20} color="#1e3a8a" />}
          value={last10Minutes.value}
          period={last10Minutes.period}
        />
        <CardHeader
          title="SPAM"
          icon={<Megaphone size={20} color="red" />}
          value={spamCount.value}
          period={spamCount.period}
        />
        <CardHeader
          title="AGENTES TOP"
          icon={<UserRoundCheck size={20} color="purple" />}
          value={top3Agents.value}
          period={top3Agents.period}
        />
        <CardHeader
          title="TOTAL DE LLAMADAS"
          icon={<SquareActivity size={20} color="green" />}
          value={totalCalls.value}
          period={totalCalls.period}
        />
      </div>

      <CallList 
        calls={calls} 
        isLoading={isLoading} 
        currentPage={paginatedData?.current_page ?? 1}
        lastPage={paginatedData?.last_page ?? 1}
        total={paginatedData?.total ?? 0}
        onPageChange={(newPage) => setPage(newPage)}
      />
    </div>
  );
}
