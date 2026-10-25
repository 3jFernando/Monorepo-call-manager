<?php namespace App\Application\Actions;

use App\Application\DTOs\IncomingCallDTO;
use App\Domain\Entities\CallSession;
use App\Domain\Events\CallReceivedEvent;
use App\Domain\Repositories\CallRepositoryInterface;
use App\Domain\Services\IdempotencyServiceInterface;
use App\Domain\ValueObjects\CallId;
use App\Domain\ValueObjects\PhoneNumber;
use Illuminate\Database\UniqueConstraintViolationException;
use Laravel\Reverb\Loggers\Log;

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
        if ($callCache = $this->idempotency->getCachedResponse($dto->callId)) {
            return $this->asReplayResponse($callCache);
        }

        // 2. Evitar peticiones identicas al mistmo tiempo
        if (!$this->idempotency->lock($dto->callId)) { // Otras peticiones paralelas
            usleep(200000); // 200ms de espera para volver a buscar
            
            $existing = $this->findByCallId($callIdVo) ?? ['call_id' => $dto->callId];
            
            return $this->asReplayResponse($existing);
        }

        try {

            // 3. Buscar en la db
            if ($call = $this->findByCallId($callIdVo)) {
                $response = $this->asReplayResponse($call);
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

            $callSession = $this->repository->save($session);
            $response = $callSession->toArray();
            $response['is_idempotent_replay'] = false;

            $this->idempotency->cacheResponse($dto->callId, $response);

            # Disparar evento de Reverb para que el frontend reaccione
            event(new CallReceivedEvent($callSession));

            return $response;
        } catch (UniqueConstraintViolationException) {
            $response = $this->findByCallId($callIdVo) ??  ['call_id' => $dto->callId];
            return $this->asReplayResponse($response);

        } finally {
            $this->idempotency->delLock($dto->callId);
        }
    }

    private function asReplayResponse(array $payload): array
    {
        $payload['is_idempotent_replay'] = true;
        return $payload;
    }

    private function findByCallId(CallId $callIdVo): ?array
    {
        $call = $this->repository->findByCallId($callIdVo);
        return $call ? $call->toArray() : null;
    }

}