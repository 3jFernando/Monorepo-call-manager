<?php namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Entities\CallSession;
use App\Domain\Enums\CallStatus;
use App\Domain\Repositories\CallRepositoryInterface;
use App\Domain\ValueObjects\CallId;
use App\Domain\ValueObjects\PhoneNumber;
use App\Infrastructure\Persistence\Models\CallModel;
use DateTimeImmutable;

class EloquentCallRepository implements CallRepositoryInterface
{
    public function save(CallSession $callSession): CallSession
    {
        $model = CallModel::updateOrCreate(['call_id' => $callSession->callId->value],
            [
                'phone_number' => $callSession->phoneNumber->value,
                'status' => $callSession->status,
                'has_called_before' => $callSession->hasCalledBefore,
                'is_spam' => $callSession->isSpam
            ]
        );

        return $this->toEntityDomain($model);
    }

    public function existsByPhoneNumber(PhoneNumber $phoneNumber): bool
    {
        return CallModel::where('phone_number', $phoneNumber->value)->exists();
    }

    private function toEntityDomain(CallModel $model): CallSession
    {
        $createdAt = $model->created_at ? DateTimeImmutable::createFromInterface($model->created_at) : null;
        $status = $model->status instanceof CallStatus ? $model->status : CallStatus::from($model->status);

        return new CallSession(
            callId: new CallId($model->call_id),
            phoneNumber: new PhoneNumber($model->phone_number),
            hasCalledBefore: $model->has_called_before,
            id: $model->id,
            createdAt: $createdAt,
            status: $status,
            isSpam: $model->is_spam
        );
    }
}