<?php

namespace App\Controller;

use App\Dto\User\UserRegistrationDto;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Service\Security\FormRegistrationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, FormRegistrationService $registrationService): Response
    {
        $userDto = new UserRegistrationDto();
        $form = $this->createForm(RegistrationFormType::class, $userDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $registrationService->registerNewUser($userDto);
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
