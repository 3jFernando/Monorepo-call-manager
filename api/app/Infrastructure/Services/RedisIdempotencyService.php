<?php namespace App\Infrastructure\Services;

use App\Domain\Services\IdempotencyServiceInterface;
use Illuminate\Support\Facades\Redis;

class RedisIdempotencyService implements IdempotencyServiceInterface
{
    private const PREFIX_LOCK = 'idempotency_lock:';
    private const PREFIX_RESPONSE = 'idempotency_response:';

    public function lock(string $key, int $ttl = 10): bool
    {
        $result = Redis::set(self::PREFIX_LOCK . $key, 'locked', 'EX', $ttl, 'NX');        

        return $result !== null && $result !== false;
    }

    public function delLock(string $key): void 
    {
        Redis::del(self::PREFIX_LOCK . $key);
    }

    public function cacheResponse(string $key, array $data, int $ttl = 86400): void
    {
        Redis::setex(self::PREFIX_RESPONSE . $key, $ttl, json_encode($data));
    }

    public function getCachedResponse(string $key): ?array
    {
        $cached = Redis::get(self::PREFIX_RESPONSE . $key);
        if (!$cached) return null;

        return json_decode((string) $cached, true);
    }

}