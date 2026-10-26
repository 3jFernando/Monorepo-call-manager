<?php namespace App\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;

use App\Domain\Repositories\CallRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GetDashboardDataController
{

    public function __construct(private readonly CallRepositoryInterface $repository)
    {}

    public function __invoke(Request $request): JsonResponse
    {
        return Response::apiResponse(data: $this->repository->getDashboardData());
    }
}