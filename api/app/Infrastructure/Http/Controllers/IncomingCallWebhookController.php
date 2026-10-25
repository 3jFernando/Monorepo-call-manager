<?php namespace App\Infrastructure\Http\Controllers;

use App\Application\Actions\RegisterIncomingCallAction;
use App\Application\DTOs\IncomingCallDTO;
use App\Infrastructure\Http\Requests\IncomingCallRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class IncomingCallWebhookController
{
    public function __construct(
        private readonly RegisterIncomingCallAction $action
    ) {}

    public function __invoke(IncomingCallRequest $request): JsonResponse
    {
        $dto = IncomingCallDTO::fromArray($request->validated());

        $result = $this->action->execute($dto);

        return Response::apiResponse(data: $result);
    }
}