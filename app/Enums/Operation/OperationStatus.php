<?php

namespace App\Enums\Operation;

enum OperationStatus: string
{
    case PENDING = 'pending';
    case SUCCESS = 'success';
    case REJECTED = 'rejected';
}
