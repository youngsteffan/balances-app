<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\Operation\OperationStatus;
use App\Enums\Operation\OperationType;
use App\Models\Operation;
use App\Repositories\Balance\BalanceRepositoryInterface;
use App\Repositories\Operation\OperationRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

final readonly class BalanceService
{
    public function __construct(
        private OperationRepositoryInterface $operationRepository,
        private UserRepositoryInterface      $userRepository,
        private BalanceRepositoryInterface   $balanceRepository,
    ) {}

    public function getBalance(int $userId): float
    {
        return $this->balanceRepository->getUserBalance($userId) ?? 0;
    }

    public function processOperation(int $operationId): void
    {
        DB::transaction(function () use ($operationId) {
            $operation = $this->operationRepository->findOrFail($operationId);
            if (!$operation->isPending()) {
                throw new \Exception('Operation is not pending');
            }

            $userBalance = $this->balanceRepository->getByUserIdForUpdate($operation->user_id);
            $newAmount = $this->calculateNewBalance($userBalance->amount, $operation);

            if ($newAmount < 0) {
                throw new \Exception('Insufficient balance');
            }

            $this->balanceRepository->updateAmount($userBalance->id, $newAmount);
            $this->operationRepository->update($operation->id, ['status' => OperationStatus::SUCCESS]);
        });
    }

    public function getAvailableWithdrawalBalance(int $userId)
    {
        $user = $this->userRepository->getUserWithBalanceAndPendingWithdrawOperations($userId);

        return ($user->balance?->amount ?? 0) - $user->operations->sum('amount');
    }

    private function calculateNewBalance(float $currentAmount, Operation $operation): float
    {
        return $operation->type === OperationType::DEPOSIT
            ? $currentAmount + $operation->amount
            : $currentAmount - $operation->amount;
    }

}
