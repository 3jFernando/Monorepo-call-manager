import React from "react";

import { Phone, SquareActivity, UserRoundCheck, Megaphone } from "lucide-react";

import CallList from "@/features/calls/components/List/CallList";
import { useCallsRealtime, useGetRecentsCalls } from "@/features/calls/hooks";
import CardHeader from "@/features/calls/components/fragments/CardHeader";
import useFilterCallsToHeader from "@/features/calls/hooks/useFilterCallsToHeader";

export default function Home() {
  useCallsRealtime();

  const { data, isLoading } = useGetRecentsCalls();
  const { totalCalls, spams, hasCallsBefore, lastThreeCallsAgents } = useFilterCallsToHeader(data || []);

  return (
    <div className="flex flex-col">
      <div className="grid grid-cols-1 sm:grid-cols-4 gap-2 mb-4">
        <CardHeader
          title="LLAMADAS RECIENTES"
          icon={<Phone size={20} />}
          value={totalCalls}
          period="Registros recientes"
        />
        <CardHeader
          title="ÚLTIMOS 3 AGENTES"
          icon={<UserRoundCheck size={20} />}
          value={lastThreeCallsAgents.value}
          period={lastThreeCallsAgents.period}
        />
        <CardHeader
          title="CON HISTORIAL"
          icon={<SquareActivity size={20} />}
          value={hasCallsBefore.value}
          period={hasCallsBefore.period}
        />
        <CardHeader
          title="MARCADOS SPAM"
          icon={<Megaphone size={20} />}
          value={spams.value}
          period={spams.period}
        />
      </div>

      <CallList calls={data} isLoading={isLoading} />
    </div>
  );
}
