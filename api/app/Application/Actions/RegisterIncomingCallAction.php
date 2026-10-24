<?php namespace App\Application\Actions;

use App\Application\DTOs\IncomingCallDTO;
use App\Domain\Entities\CallSession;
use App\Domain\Repositories\CallRepositoryInterface;
use App\Domain\Services\IdempotencyServiceInterface;
use App\Domain\ValueObjects\CallId;
use App\Domain\ValueObjects\PhoneNumber;
use Illuminate\Database\UniqueConstraintViolationException;

class RegisterIncomingCallAction
{
    public function __construct(
        private readonly CallRepositoryInterface $repository,
        private readonly IdempotencyServiceInterface $idempotency
    ) {}

    public function execute(IncomingCallDTO $dto): array
    {
        $callIdVo = new CallId($dto->callId);
        $phoneVo = new PhoneNumber($dto->phoneNumber);

        // 1. Verificar si ya esta cacheada
        $isCached = $this->idempotency->getCachedResponse($dto->callId);
        if ($isCached !== null) {
            $isCached['is_idempotent_replay'] = true;
            return $isCached;
        }

        // 2. Evitar peticiones paralelas al mistmo tiempo
        $lockCallId = $this->idempotency->lock($dto->callId);
        if (!$lockCallId) {
            usleep(200000); // 200ms
            $existing = $this->repository->findByCallId($callIdVo);
            if ($existing) {
                $response = $existing->toArray();
                $response['is_idempotent_replay'] = true;
                return $response;
            }
        }

        try {
            // 3. Buscar en la db
            $existingInDb = $this->repository->findByCallId($callIdVo);
            if ($existingInDb) {
                $response = $existingInDb->toArray();
                $response['is_idempotent_replay'] = true;
                $this->idempotency->cacheResponse($dto->callId, $response);
                return $response;
            }

            // 4. Comprobar si es nueva o no la llamada
            $hasCalledBefore = $this->repository->existsByPhoneNumber($phoneVo);

            // 5. Crear y guardar la entidad
            $session = new CallSession(
                callId: $callIdVo,
                phoneNumber: $phoneVo,                
                agent: $dto->agent,
                duration: $dto->duration,
                recordingUrl: $dto->recordingUrl,                
                hasCalledBefore: $hasCalledBefore
            );

            $savedSession = $this->repository->save($session);
            $response = $savedSession->toArray();
            $response['is_idempotent_replay'] = false;

            $this->idempotency->cacheResponse($dto->callId, $response);

            return $response;
        } catch (UniqueConstraintViolationException) {
            
            $existing = $this->repository->findByCallId($callIdVo);
            $response = $existing ? $existing->toArray() : ['call_id' => $dto->callId];
            $response['is_idempotent_replay'] = true;
            return $response;

        } finally {
            $this->idempotency->delLock($dto->callId);
        }
    }
}