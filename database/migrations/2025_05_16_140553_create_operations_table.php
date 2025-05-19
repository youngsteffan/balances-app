<?php

use App\Enums\Operation\OperationStatus;
use App\Enums\Operation\OperationType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('operations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->decimal('amount', 15, 2);
            $table->enum('type', [OperationType::DEPOSIT->value, OperationType::WITHDRAW->value]);
            $table->enum(
                'status',
                [OperationStatus::PENDING->value, OperationStatus::SUCCESS->value, OperationStatus::REJECTED->value]
            );
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('balance_operations');
    }
};
