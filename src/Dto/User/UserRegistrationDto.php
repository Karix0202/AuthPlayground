<?php

namespace App\Dto\User;

use App\Entity\User;
use App\Validator\UniqueUserEmail;
use Symfony\Component\Validator\Constraints as Assert;

class UserRegistrationDto
{
    #[Assert\Email]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[UniqueUserEmail]
    private string $email;

    #[Assert\NotBlank]
    #[Assert\NotNull]
    #[Assert\Length(min: 6)]
    private string $plainPassword;

    #[Assert\NotBlank]
    #[Assert\NotNull]
    private string $address;

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }
}