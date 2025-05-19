<?php

declare(strict_types=1);

namespace App\Jobs;

use App\DTOs\OperationDTO;
use App\Services\BalanceService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class ProcessOperationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private readonly int $operationId,
    ) {}

    public function handle(BalanceService $balanceService): void
    {
        $balanceService->processOperation($this->operationId);
    }
}
