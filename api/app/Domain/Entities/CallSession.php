<?php namespace App\Domain\Entities;

use App\Domain\ValueObjects\{
    CallId,
    PhoneNumber
};
use DateTimeImmutable;
use JsonSerializable;

class CallSession implements JsonSerializable
{
    public function __construct(
        public readonly CallId $callId,
        public readonly PhoneNumber $phoneNumber,
        public readonly string $agent,
        public readonly int $duration,
        public readonly string $recordingUrl,
        public readonly bool $hasCalledBefore,
        public bool $isSpam = false,
        public readonly ?int $id = null,
        public readonly ?DateTimeImmutable $createdAt = null
    ) {}

    public function markAsSpam(): void
    {
        $this->isSpam = true;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'call_id' => $this->callId->value,
            'phone_number' => $this->phoneNumber->value,
            'agent' => $this->agent,
            'duration' => $this->duration,
            'recording_url' => $this->recordingUrl,
            'has_called_before' => $this->hasCalledBefore,
            'is_spam' => $this->isSpam,
            'created_at' => $this->createdAt?->format(DateTimeImmutable::ATOM),
        ];
    }

}