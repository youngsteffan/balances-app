<?php

declare(strict_types=1);

namespace App\Repositories\Operation;

use App\Models\Operation;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class OperationRepository implements OperationRepositoryInterface
{
    public function findOrFail(int $id): Operation
    {
        return Operation::findOrFail($id);
    }

    public function create(array $data): Operation
    {
        return Operation::create([
            'user_id' => $data['user_id'],
            'amount' => $data['amount'],
            'type' => $data['type'],
            'status' => $data['status'],
            'description' => $data['description']
        ]);
    }

    public function update(int $id, array $data): int
    {
        return Operation::whereId($id)->update($data);
    }


    public function getLatestOperations(int $userId, int $limit = 5): Collection
    {
        return Operation::where('user_id', $userId)
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function getPaginatedOperations(
        int $userId,
        ?string $search = null,
        string $sortBy = 'created_at',
        string $sortDirection = 'desc',
        int $perPage = 5
    ): LengthAwarePaginator {
        $query = Operation::where('user_id', $userId);

        if ($search) {
            $query->where('description', 'like', "%{$search}%");
        }

        return $query
            ->orderBy($sortBy, $sortDirection)
            ->paginate($perPage);
    }

    public function getPendingOperations(int $userId): Collection
    {
        // TODO: Implement getPendingOperations() method.
    }
}
