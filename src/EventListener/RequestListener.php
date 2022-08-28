<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Security\Core\Security;

class RequestListener
{
    public function __construct(
        private readonly Security $security
    ) {}


    public function onKernelRequest(RequestEvent $requestEvent): void
    {
        if (!($user = $this->security->getUser())) {
            return;
        }

        if ($requestEvent->getRequest()->getRequestUri() !== '/complete' &&
            !$user->getAddress()
        ) {
            $requestEvent->setResponse(new RedirectResponse('/complete'));
        }
    }
}