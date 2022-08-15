<?php

namespace App\Dto\User;

use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

class UserRegistrationDto
{
    #[Assert\Email]
    #[Assert\NotBlank]
    #[Assert\NotNull]
    private string $email;

    #[Assert\NotBlank]
    #[Assert\NotNull]
    private string $notHashedPassword;


    public function __construct(string $email, string $notHashedPassword)
    {
        $this->email = $email;
        $this->notHashedPassword = $notHashedPassword;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getNotHashedPassword(): string
    {
        return $this->notHashedPassword;
    }
}