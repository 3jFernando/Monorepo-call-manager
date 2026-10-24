<?php namespace App\Domain\Repositories;

use App\Domain\Entities\CallSession;
use App\Domain\ValueObjects\CallId;
use App\Domain\ValueObjects\PhoneNumber;

interface CallRepositoryInterface 
{
    public function save(CallSession $callSession): CallSession;

    public function findByCallId(CallId $callId): ?CallSession;

    public function existsByPhoneNumber(PhoneNumber $phoneNumber): bool;
  
    public function getRecentCalls(int $limit = 15): array;
}