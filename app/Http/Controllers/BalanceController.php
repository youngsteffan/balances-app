<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\BalanceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class BalanceController extends Controller
{
    public function __construct(private readonly BalanceService $balanceService) {}
    public function getBalance(Request $request): JsonResponse
    {
        $balance = $this->balanceService->getBalance($request->user()->id);

        return response()->json(compact('balance'));
    }
}
