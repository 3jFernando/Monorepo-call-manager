<?php namespace App\Application\Actions;

use App\Domain\Exceptions\CallNotFoundException;
use App\Domain\Repositories\CallRepositoryInterface;
use App\Domain\Services\IdempotencyServiceInterface;
use App\Domain\ValueObjects\CallId;

class MarkCallAsSpamAction
{
    public function __construct(
        private readonly CallRepositoryInterface $repository,
        private readonly IdempotencyServiceInterface $idempotency
    ) {}

    public function execute(string $rawCallId): array
    {
        $callSession = $this->repository->findByCallId(new CallId($rawCallId));
        if (!$callSession) throw CallNotFoundException::withoutId($rawCallId);

        $callSession->markAsSpam();

        $savedSession = $this->repository->save($callSession);
        $response = $savedSession->toArray();

        $this->idempotency->cacheResponse($rawCallId, $response);

        return $response;
    }
}
