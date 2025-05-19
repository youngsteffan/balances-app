<?php

namespace App\DTOs;

class IndexOperationRequestDTO
{
    public function __construct(
        public readonly int     $userId,
        public readonly ?string $search,
        public readonly string  $sortField,
        public readonly string  $sortDirection,
        public readonly int     $perPage
    )
    {
    }
}
