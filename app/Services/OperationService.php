<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\OperationDTO;
use App\Models\Operation;
use App\Repositories\Operation\OperationRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

final readonly class OperationService
{
    public function __construct(
        private OperationRepositoryInterface $operationRepository
    ) {}

    public function create(OperationDto $operationDto): Operation
    {
        return $this->operationRepository->create($operationDto->toArray());
    }

    public function getLatestOperations(int $userId, int $limit): Collection
    {
        return $this->operationRepository->getLatestOperations($userId, $limit);
    }

    public function getPaginatedOperations(
        int     $userId,
        ?string $search = null,
        string  $sortBy = 'created_at',
        string  $sortDirection = 'desc',
        int     $perPage = 7
    ): LengthAwarePaginator
    {
        return $this->operationRepository->getPaginatedOperations(
            $userId,
            $search,
            $sortBy,
            $sortDirection,
            $perPage
        );
    }
}
