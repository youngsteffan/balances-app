<?php

declare(strict_types=1);

namespace App\Repositories\Balance;

use App\Models\Balance;

final class BalanceRepository implements BalanceRepositoryInterface
{

    public function create(int $userId, float $amount): Balance
    {
        return Balance::create(['user_id' => $userId, 'amount' => $amount]);
    }

    public function getByUserIdForUpdate(int $userId): ?Balance
    {
        return Balance::where('user_id', $userId)->lockForUpdate()->firstOrFail();
    }

    public function updateAmount(int $balanceId, float $amount): void
    {
        Balance::where('id', $balanceId)->update(['amount' => $amount]);
    }

    public function getUserBalance(int $userId): ?float
    {
        return Balance::where('user_id', $userId)
            ->value('amount');
    }
}
