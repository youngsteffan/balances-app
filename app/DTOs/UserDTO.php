<?php

namespace App\DTOs;

readonly class UserDTO
{
    public function __construct(
        public string $login,
        public string $password,
    )
    {
        $this->validate();
    }

    private function validate(): void
    {
        if (empty($this->login)) {
            throw new \InvalidArgumentException('Login cannot be empty');
        }

        if (empty($this->password)) {
            throw new \InvalidArgumentException('Password cannot be empty');
        }
    }
}
