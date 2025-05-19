<?php

namespace App\Models;

use App\Enums\Operation\OperationStatus;
use App\Enums\Operation\OperationType;
use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    protected $fillable = ['user_id', 'amount', 'type', 'status', 'description'];

    protected $casts = [
        'status' => OperationStatus::class,
        'type' => OperationType::class,
    ];

    public function isPending(): bool
    {
        return $this->status === OperationStatus::PENDING;
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function balance()
    {
        return $this->belongsTo(Balance::class, 'user_id', 'user_id');
    }
}
