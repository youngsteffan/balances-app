<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Operation\OperationIndexRequest;
use App\Services\OperationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class OperationController extends Controller
{

    public function __construct(
        private OperationService $operationService
    ) {}

    public function index(OperationIndexRequest $request): JsonResponse
    {
        $operations = $this->operationService->getPaginatedOperations(
            userId: $request->user()->id,
            search: $request->input('search'),
            sortBy: $request->input('sort', 'created_at'),
            sortDirection: $request->input('direction', 'desc'),
        );

        return response()->json($operations);

    }

    public function latest(Request $request): JsonResponse
    {
        $operations = $this->operationService->getLatestOperations(
            userId: $request->user()->id,
            limit: 5
        );

        return response()->json(['operations' => $operations]);
    }
}
