import React from "react";
import type { Call } from "@/features/calls/types";
import { formatDate } from "@/shared/utils/formatDate";

import { Globe, TriangleAlert, Play, CircleCheckBig } from "lucide-react";
import { getFirstLetter } from "@/shared/utils/getFirstLetter";
import { ButtonSpam } from "@/ui";

interface Props {
  calls: Call[];
  isLoading: boolean;
}

export default function CallList({ calls, isLoading }: Props) {
  if (isLoading) {
    return <p>Cargando llamadas...</p>;
  }

  return (
    <div className="bg-gray-200/20 rounded-md border border-gray-100 shadow p-4">
      <div className="mb-2">
        <h1 className="text-lg font-bold">
          Registro de llamadas
          <span className="text-xs font-bold px-4 py-1 bg-gray-200/50 rounded ml-2">
            {calls?.length} llamadas
          </span>
        </h1>
        <p className="text-xs text-gray-400">
          Últimas llamadas agregadas, ordenadas por fecha descendente
        </p>
      </div>

      <table>
        <thead>
          <tr>
            <th>
              <div className="flex items-center gap-2">
                <Globe size={17} color="purple" /> Teléfono
              </div>
            </th>
            <th>Agente</th>
            <th>Historial</th>
            <th>Duración</th>
            <th>Grabación</th>
            <th>Fecha</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          {!calls || calls.length === 0 ? (
            <tr>
              <td colSpan="7">
                No hay llamadas registradas en la base de datos.
              </td>
            </tr>
          ) : (
            calls.map((call: Call) => (
              <tr key={call.id}>
                <td>{call.phone_number}</td>
                <td>
                  <div className="flex items-center gap-2">
                    <div className="bg-purple-200/50 text-purple-800 p-2 rounded-full w-8 h-8 flex items-center justify-center">
                      {getFirstLetter(call.agent)}
                    </div>
                    <span>{call.agent}</span>
                  </div>
                </td>
                <td>
                  <div className="flex items-center justify-center">
                    <div
                      className={
                        call.has_called_before
                          ? "flex items-center gap-1 bg-green-500/10 px-2 py-1 rounded-md w-fit text-xs"
                          : " text-xs flex items-center gap-1 bg-gray-500/10 px-2 py-1 rounded-md w-fit"
                      }
                    >
                      <CircleCheckBig
                        className={
                          call.has_called_before
                            ? "text-green-400"
                            : "text-gray-400"
                        }
                        size={14}
                      />
                      {call.has_called_before ? "Sí" : "No"}
                    </div>
                  </div>
                </td>
                <td> {call.duration} </td>
                <td>
                  <div className="flex items-center justify-center">
                    <a
                      href={call.recording_url}
                      target="_blank"
                      className="text-xs text-purple-500 flex items-center justify-center gap-1 border border-gray-200 rounded-md px-2 py-1 hover:bg-gray-100 hover:cursor-pointer w-fit"
                    >
                      <Play size={15} color="purple" />
                      Ver
                    </a>
                  </div>
                </td>
                <td>{formatDate(call.created_at)}</td>
                <td>
                  <ButtonSpam disabled={call.is_spam}>
                    <TriangleAlert size={15} className="mr-1" />
                    {call.is_spam ? "SPAM" : "Marcar como spam"}
                  </ButtonSpam>
                </td>
              </tr>
            ))
          )}
        </tbody>
      </table>
    </div>
  );
}
