<?php namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Entities\CallSession;
use App\Domain\Repositories\CallRepositoryInterface;
use App\Domain\ValueObjects\CallId;
use App\Domain\ValueObjects\PhoneNumber;
use App\Infrastructure\Persistence\Models\CallModel;
use DateTimeImmutable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class EloquentCallRepository implements CallRepositoryInterface
{

    public function __construct(private CallModel $model) {}

    public function save(CallSession $callSession): CallSession
    {
        $model = $this->model::updateOrCreate(['call_id' => $callSession->callId->value],
            [
                'phone_number' => $callSession->phoneNumber->value,
                'agent' => $callSession->agent,
                'duration' => $callSession->duration,
                'recording_url' => $callSession->recordingUrl,
                'has_called_before' => $callSession->hasCalledBefore,
                'is_spam' => $callSession->isSpam
            ]
        );

        return $this->toEntityDomain($model);
    }

    public function findByCallId(CallId $callId): ?CallSession
    {
        $model = $this->model::where('call_id', $callId->value)->first();
        return $model ? $this->toEntityDomain($model) : null;
    }

    public function existsByPhoneNumber(PhoneNumber $phoneNumber): bool
    {
        return $this->model::where('phone_number', $phoneNumber->value)->exists();
    }

    public function getCalls(int $page = 1, int $perPage = 10): LengthAwarePaginator
    {
        return $this->model::query()
            ->orderBy('created_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page)
            ->through(fn (CallModel $model) => $this->toEntityDomain($model));
    }

    public function getDashBoardData(): ?object
    {
        $totals = $this->model::select(
            DB::raw("
                COUNT(*) as total_calls,
                COUNT(CASE WHEN created_at >= NOW() - INTERVAL '10 minutes' THEN 1 END) as last_10_minutes,
                COUNT(CASE WHEN is_spam = true THEN 1 END) as spam_count
            ")
        )->first();

        $topThreeAgents = CallModel::query()
            ->select('agent', DB::raw('COUNT(*) as total_llamadas'))
            ->whereNotNull('agent')
            ->groupBy('agent')
            ->orderByDesc('total_llamadas')
            ->limit(3)
            ->get()
            ->pluck('agent')->implode(', ');

        $totals->top_3_agents = $topThreeAgents;
        return $totals;
    }

    private function toEntityDomain(CallModel $model): CallSession
    {
        $createdAt = $model->created_at ? DateTimeImmutable::createFromInterface($model->created_at) : null;

        return new CallSession(
            callId: new CallId($model->call_id),
            phoneNumber: new PhoneNumber($model->phone_number),
            agent: $model->agent,
            duration: $model->duration,
            recordingUrl: $model->recording_url,
            hasCalledBefore: $model->has_called_before,
            isSpam: $model->is_spam,
            id: $model->id,
            createdAt: $createdAt            
        );
    }
}