<?php

namespace App\DTOs;

use App\Enums\Operation\OperationStatus;
use App\Enums\Operation\OperationType;

final readonly class OperationDTO
{
    public function __construct(
        public int             $userId,
        public float           $amount,
        public OperationType   $type,
        public OperationStatus $status,
        public string          $description
    ) {}

    public function toArray(): array
    {
        return [
            'user_id' => $this->userId,
            'amount' => $this->amount,
            'type' => $this->type->value,
            'status' => $this->status->value,
            'description' => $this->description,
        ];
    }
}
