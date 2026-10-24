<?php namespace App\Domain\Services;

interface IdempotencyServiceInterface
{
    public function lock(string $key, int $ttlSeconds = 10): bool;

    public function delLock(string $key): void;

    public function cacheResponse(string $key, array $data, int $ttlSeconds = 86400): void;

    public function getCachedResponse(string $key): ?array;
}