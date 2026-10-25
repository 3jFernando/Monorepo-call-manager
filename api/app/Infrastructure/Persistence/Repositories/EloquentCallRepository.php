<?php namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Entities\CallSession;
use App\Domain\Repositories\CallRepositoryInterface;
use App\Domain\ValueObjects\CallId;
use App\Domain\ValueObjects\PhoneNumber;
use App\Infrastructure\Persistence\Models\CallModel;
use DateTimeImmutable;

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

    public function getRecentCalls(int $limit = 30): array
    {
        return $this->model::query()
            ->latest('id')
            ->limit($limit)
            ->get()
            ->map(fn (CallModel $model) => $this->toEntityDomain($model))
            ->all();
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