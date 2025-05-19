<?php

namespace App\Observers;

use App\Models\Balance;
use App\Models\User;
use App\Repositories\Balance\BalanceRepository;
use App\Repositories\Balance\BalanceRepositoryInterface;

final readonly class UserObserver
{

    public function __construct(private BalanceRepositoryInterface $balanceRepository) {}
    public function created(User $user)
    {
        $this->balanceRepository->create($user->id, 0);
    }
}
