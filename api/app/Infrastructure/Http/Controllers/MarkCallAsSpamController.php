<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers;

use App\Application\Actions\MarkCallAsSpamAction;
use App\Domain\Exceptions\CallNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

class MarkCallAsSpamController
{
    public function __construct(
        private readonly MarkCallAsSpamAction $action
    ) {}

    public function __invoke(string $callId): JsonResponse
    {
        try {

            $result = $this->action->execute($callId);
            return Response::apiResponse(data: $result);

        } catch (CallNotFoundException $e) {
            return Response::apiResponse(message: $e->getMessage(), status: 404);
        } catch (Throwable $tr) {
            return Response::apiResponse(message: "No fue posible procesar la solicitud, comunicate con el administrador del sistema.", status: $tr->getCode());
        }
    }
}
