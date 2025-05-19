<?php

declare(strict_types=1);

namespace App\Repositories\User;

use App\Enums\Operation\OperationStatus;
use App\Enums\Operation\OperationType;
use App\Models\User;

final class UserRepository implements UserRepositoryInterface
{

    public function findByLogin(string $login): ?User
    {
        return User::where('login', $login)->first();
    }

    public function create(
        string $login,
        string $password,
    ): User
    {
        return User::create([
            'login' => $login,
            'password' => $password,
        ]);
    }

    public function getUserWithBalanceAndPendingWithdrawOperations(int $userId): User
    {
        return User::with([
            'balance',
            'operations' => fn($query) => $query
                ->where('status', OperationStatus::PENDING)
                ->where('type', OperationType::WITHDRAW)
        ])->findOrFail($userId);
    }
}
