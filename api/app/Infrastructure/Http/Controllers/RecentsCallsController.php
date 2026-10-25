<?php namespace App\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;

use App\Domain\Repositories\CallRepositoryInterface;
use Illuminate\Http\Response;

class RecentsCallsController
{

    public function __construct(private readonly CallRepositoryInterface $repository)
    {}

    public function __invoke(): JsonResponse
    {
        $getRecentCalls = $this->repository->getRecentCalls();

        return Response::apiResponse(data: $getRecentCalls);
    }
}