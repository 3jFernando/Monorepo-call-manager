import { Call } from '@/features/calls/types';

export default function useFilterCallsToHeader(calls: Call[]) {
    const spams = calls.filter((call) => call.is_spam).length || 0;
    const hasCallsBefore = calls.filter((call) => call.has_called_before).length || 0;
    const lastThreeCallsAgents = [...new Set(calls.map((call) => call.agent))].slice(0, 3);

    return {
        totalCalls: calls.length,
        spams: {
            value: `${spams} / ${calls.length}`,
            period: `${(spams / calls.length * 100).toFixed(0)}%`
        },
        hasCallsBefore: {
            value: `${hasCallsBefore} / ${calls.length}`,
            period: `${(hasCallsBefore / calls.length * 100).toFixed(0)}%`
        },
        lastThreeCallsAgents: {
            value: lastThreeCallsAgents.length || 0,
            period: lastThreeCallsAgents.join(', ')
        }
    };
}