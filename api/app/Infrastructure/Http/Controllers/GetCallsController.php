<?php namespace App\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;

use App\Domain\Repositories\CallRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GetCallsController
{

    public function __construct(private readonly CallRepositoryInterface $repository)
    {}

    public function __invoke(Request $request): JsonResponse
    {
        $page = $request->query('page', 1);
        $perPage =$request->query('perPage', 10);

        $calls = $this->repository->getCalls(page: $page, perPage: $perPage);
        return Response::apiResponse(data: $calls);
    }
}