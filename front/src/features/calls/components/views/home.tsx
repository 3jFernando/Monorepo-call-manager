import React from "react";

import CallList from "@/features/calls/components/List/CallList";
import { useCallsRealtime } from "@/features/calls/hooks";

export default function Home() {

  useCallsRealtime();
 
  return (
    <div>
      <p>Mostrando llamadas recientes</p>

      <CallList />
    </div>
  );
}
