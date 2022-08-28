<?php

namespace App\Dto\User;

use Symfony\Component\Validator\Constraints as Assert;

class UserCompleteRegistration
{
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private string $address;

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }
}