<?php

namespace App\Repositories\Balance;

use App\Models\Balance;

interface BalanceRepositoryInterface
{

    public function getByUserIdForUpdate(int $userId): ?Balance;

    public function updateAmount(int $balanceId, float $amount): void;

    public function create(int $userId, float $amount): Balance;

    public function getUserBalance(int $userId): ?float;

}
