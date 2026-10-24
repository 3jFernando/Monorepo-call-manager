<?php namespace App\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;

use App\Domain\Repositories\CallRepositoryInterface;

class RecentsCallsController
{

    public function __construct(private readonly CallRepositoryInterface $repository)
    {}

    public function __invoke(): JsonResponse
    {
        $getRecentCalls = $this->repository->getRecentCalls();

        return response()->json([
            'message' => 'Recent calls retrieved successfully',
            'data' => $getRecentCalls
        ], JsonResponse::HTTP_OK);
    }
}