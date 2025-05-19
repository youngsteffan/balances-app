<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\DTOs\OperationDTO;
use App\Enums\Operation\OperationStatus;
use App\Enums\Operation\OperationType;
use App\Exceptions\Balance\InsufficientBalanceException;
use App\Http\Requests\Operation\OperationRequest;
use App\Jobs\ProcessOperationJob;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\BalanceService;
use App\Services\OperationService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

final class CreateOperationCommand extends Command
{
    protected $signature = 'create:operation
                            {login : User login}
                            {amount : Operation amount}
                            {type : Operation type (deposit/withdraw)}
                            {description : Operation description}';

    protected $description = 'Create balance operation by user login';

    public function __construct(
        private readonly OperationService        $operationService,
        private readonly UserRepositoryInterface $userRepository,
        private readonly BalanceService          $balanceService,
    )
    {
        parent::__construct();
    }

    public function handle(): int
    {
        try {
            $this->validateArguments();

            $operationDTO = new OperationDTO(...$this->prepareData());
            if ($operationDTO->type === OperationType::WITHDRAW) {
                $this->ensureSufficientBalance($operationDTO);
            }

            $operation = $this->operationService->create($operationDTO);

            ProcessOperationJob::dispatch($operation->id);

            $this->info('Operation queued successfully');
            return self::SUCCESS;
        } catch (\InvalidArgumentException | InsufficientBalanceException $e) {
            $this->error($e->getMessage());
            return self::FAILURE;
        }
    }

    private function ensureSufficientBalance(OperationDTO $operationDTO): void
    {
        $userAvailableBalance = $this->balanceService->getAvailableWithdrawalBalance($operationDTO->userId);
        if ($userAvailableBalance < $operationDTO->amount) {
            throw new InsufficientBalanceException('Insufficient balance');
        }
    }

    private function prepareData(): array
    {
        $user = $this->userRepository->findByLogin($this->argument('login'));
        if (!$user) {
            throw new \InvalidArgumentException('User not found');
        }

        return [
            'userId' => $user->id,
            'amount' => (float)$this->argument('amount'),
            'type' => OperationType::from($this->argument('type')),
            'status' => OperationStatus::PENDING,
            'description' => $this->argument('description'),
        ];
    }

    private function validateArguments(): void
    {
        $request = new OperationRequest($this->arguments());
        $validator = Validator::make(
            $request->all(),
            $request->rules()
        );

        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }
    }
}
