<?php

namespace App\Controller;

use App\Dto\User\UserCompleteRegistration;
use App\Form\CompleteRegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_user_profile')]
    public function index(): Response
    {
        return $this->render('user/profile.html.twig');
    }

    #[Route('/complete', name: 'app_user_complete_registration')]
    public function completeRegistration(Request $request, EntityManagerInterface $em): Response
    {
        $userCompleteRegistrationDto = new UserCompleteRegistration();
        $form = $this->createForm(CompleteRegistrationType::class, $userCompleteRegistrationDto);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getUser()->setAddress(
                $userCompleteRegistrationDto->getAddress()
            );
            $em->flush();

            return $this->redirectToRoute('app_user_profile');
        }

        return $this->render('registration/complete.html.twig', [
            'form' => $form->createView()
        ]);
    }
}