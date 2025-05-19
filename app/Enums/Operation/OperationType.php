<?php

namespace App\Enums\Operation;

enum OperationType: string
{
    case DEPOSIT = 'deposit';
    case WITHDRAW = 'withdraw';
}

