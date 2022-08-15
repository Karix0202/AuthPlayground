<?php

namespace App\Service\Security;

use App\Dto\User\UserRegistrationDto;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class FormRegistrationService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {}

    public function registerNewUser(UserRegistrationDto $registrationDto): void
    {
        $user = new User();
        $user
            ->setEmail($registrationDto->getEmail())
            ->setPassword(
                $this->passwordHasher->hashPassword(
                    $user,
                    $registrationDto->getPlainPassword()
                )
            )
        ;

        $this->userRepository->add($user, true);
    }
}