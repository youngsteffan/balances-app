<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\DTOs\UserDTO;
use App\Services\UserService;
use Illuminate\Console\Command;

final class CreateUserCommand extends Command
{
    protected $signature = 'create:user
                            {login : User login}
                            {password : User password}';

    protected $description = 'Create user';

    public function handle(UserService $userService)
    {
        try {
            $userService->create(new UserDTO(
                login: $this->argument('login'),
                password: $this->argument('password'),
            ));

            $this->info('User created successfully!');

            return self::SUCCESS;
        } catch (\InvalidArgumentException $e) {
            $this->error("Validation error: {$e->getMessage()}");
            return self::FAILURE;
        }
    }
}
