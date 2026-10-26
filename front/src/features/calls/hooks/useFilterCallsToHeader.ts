import { useGetDashboardData } from '@/features/calls/hooks/useGetDashboardData';

export default function useFilterCallsToHeader() {
    const { data: dashboardData, isLoading } = useGetDashboardData();

    const last10Minutes = dashboardData?.last_10_minutes || 0;
    const spamCount = dashboardData?.spam_count || 0;
    const top3Agents = dashboardData?.top_3_agents || [];
    const totalCalls = dashboardData?.total_calls || 0;

    return {
        last10Minutes: {
            value: isLoading ? 'Cargando...' : last10Minutes,
            period: 'En los últimos 10 minutos'
        },
        spamCount: {
            value: isLoading ? 'Cargando...' : `${ spamCount } / ${totalCalls}`,
            period: `${(spamCount / totalCalls * 100).toFixed(0)}%`
        },
        top3Agents: {
            value: 3,
            period: isLoading ? 'Cargando...' : top3Agents.length > 0 ? top3Agents : "No hay agentes recientes"
        },
        totalCalls: {
            value: isLoading ? 'Cargando...' : totalCalls,
            period: "Llamadas totales"
        }
    }; 
}