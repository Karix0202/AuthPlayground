<?php

namespace App\Service\Security;

use App\Dto\User\UserRegistrationDto;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use App\Security\LoginFormAuthenticator;
use App\Service\Mail\EmailVerificationService;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class FormRegistrationService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly EmailVerificationService $emailVerificationService,
        private readonly UserAuthenticatorInterface $authenticator,
        private readonly LoginFormAuthenticator $loginFormAuthenticator,
    ) {}

    public function registerNewUser(Request $request, UserRegistrationDto $registrationDto): ?Response
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
            ->setAddress($registrationDto->getAddress())
            ->setRegisteredViaSocialMedia(false)
        ;
        $this->userRepository->add($user, true);

        $this->emailVerificationService->send($user);

        return $this->authenticator->authenticateUser(
            $user,
            $this->loginFormAuthenticator,
            $request
        );
    }
}