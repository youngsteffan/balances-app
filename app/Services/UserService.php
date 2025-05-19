<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\UserDTO;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;

final readonly class UserService
{
    public function __construct(
        private UserRepositoryInterface      $userRepository,
    ) {}

    public function create(UserDTO $userDTO): User
    {
        return $this->userRepository->create(
            $userDTO->login,
            bcrypt($userDTO->password),
        );
    }
}
