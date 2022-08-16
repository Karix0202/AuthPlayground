<?php

namespace App\Service\Security;

use App\Dto\User\UserRegistrationDto;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class FormRegistrationService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly EmailVerifier $emailVerifier,
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

        $this->emailVerifier->sendEmailConfirmation(
            'app_verify_email',
            $user,
            (new TemplatedEmail())
                ->from(new Address('mailer@domain.com', 'AuthPlayground'))
                ->to($user->getEmail())
                ->subject('Please confirm your Email')
                ->htmlTemplate('registration/confirmation_email.html.twig')
        );
    }
}