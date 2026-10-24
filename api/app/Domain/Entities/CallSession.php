<?php namespace App\Domain\Entities;

use App\Domain\Enums\CallStatus;
use App\Domain\ValueObjects\{
    CallId,
    PhoneNumber
};
use DateTimeImmutable;

class CallSession 
{
    public function __construct(
        public readonly CallId $callId,
        public readonly PhoneNumber $phoneNumber,
        public CallStatus $status,
        public readonly bool $hasCalledBefore,
        public bool $isSpam = false,
        public readonly ?int $id = null,
        public readonly ?DateTimeImmutable $createdAt = null
    ) {}

    public function markAsSpam(): void
    {
        $this->status = CallStatus::SPAM;
        $this->isSpam = true;
    }

}