import React from "react";

import { PhoneCall } from "lucide-react";

export default function Header() {
  return (
    <header className="p-3 bg-white w-full text-black border-b border-gray-200 mb-4">
      <div className="flex items-center gap-4 justify-between">
        <div className="flex items-center gap-4">
          <PhoneCall size={44} color="white" className="bg-violet-800 p-2.5 rounded" />
          <div className="flex flex-col">
            <strong className="text-2xl text-violet-800">Call Manager</strong>
            <span>Panel de Telefonía</span>
          </div>
        </div>

        <div className="flex items-center gap-4">
          <div className="flex items-center gap-2 bg-green-600/20 px-6 py-2 rounded-lg">
            <div className="w-3 h-3 rounded-full bg-green-500 animate-pulse"></div>
            <span className="text-xs">Servicio disponible</span>
          </div>
        </div>
      </div>
    </header>
  );
}
