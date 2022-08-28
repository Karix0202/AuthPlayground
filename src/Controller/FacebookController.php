<?php

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\FacebookUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FacebookController extends AbstractController
{
    #[Route('/facebook/connect', name: 'connect_facebook_start')]
    public function connect(ClientRegistry $clientRegistry): RedirectResponse
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_user_profile');
        }

        return $clientRegistry
                ->getClient('facebook_main')
                ->redirect([
                    'public_profile', 'email'
                ]);
    }

    #[Route('/facebook/connect/check', name: 'connect_facebook_check')]
    public function connectCheck(Request $request, ClientRegistry $clientRegistry)
    {}
}