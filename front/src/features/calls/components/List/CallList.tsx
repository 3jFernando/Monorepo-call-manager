import React from "react";
import { useGetRecentsCalls } from "@/features/calls/hooks";
import type { Call } from "@/features/calls/types";
import { formatDate } from "@/shared/utils/formatDate";

export default function CallList() {
  const { data, isLoading } = useGetRecentsCalls();

  if (isLoading) {
    return <p>Cargando llamadas...</p>;
  }

  return (
    <div>
      <table style={{ width: '100%'}}>
          <thead>
            <tr style={{ background: '#cdcdcdff'}}>              
              <th>Teléfono</th>
              <th>Agente</th>
              <th>Historial</th>
              <th>Duración</th>
              <th>Grabación</th>
              <th>Fecha</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            {!data || data.length === 0 ? (
              <tr>
                <td colSpan="7">
                  No hay llamadas registradas en la base de datos.
                </td>
              </tr>
            ) : (
              data.map((call: Call) => (
                <tr key={call.id}>
                  <td> {call.phone_number} </td>
                  <td> {call.agent}</td>
                  <td>{call.has_called_before ? 'Sí' : 'No'} </td>
                  <td> {call.duration} </td>
                  <td> 
                    <a href={call.recording_url} target="_blank">Ver</a>
                  </td>
                  <td>{formatDate(call.created_at)}</td>
                  <td>
                    <button disabled={call.is_spam}>
                      {call.is_spam ? 'SPAM' : 'Marcar como spam'}
                    </button>
                  </td>
                </tr>
              ))
            )}
          </tbody>
        </table>
    </div>
  );
}
