<?php

namespace App\Repositories\Operation;

use App\Models\Operation;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface OperationRepositoryInterface
{

    public function findOrFail(int $id): Operation;

    public function create(array $data): Operation;

    public function update(int $id, array $data): int;

    public function getPendingOperations(int $userId): Collection;

    public function getLatestOperations(int $userId, int $limit): Collection;

    public function getPaginatedOperations(
        int     $userId,
        ?string $search,
        string  $sortBy,
        string  $sortDirection,
        int     $perPage
    ): LengthAwarePaginator;
}
