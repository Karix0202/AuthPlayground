<?php

namespace App\Service\Mail;

use App\Entity\User;
use App\Security\EmailVerifier;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;

class EmailVerificationService
{
    public function __construct(
        private readonly EmailVerifier $emailVerifier
    ) {}

    public function send(User $user): void
    {
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