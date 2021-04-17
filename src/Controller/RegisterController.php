<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{
    #[Route('/register', name: 'register')]
    public function register(Request $request, UserPasswordEncoderInterface $password_encoder): Response
    {
        $user = new User();

        $formUser = $this->createForm(RegistrationType::class, $user);

        $formUser->handleRequest($request);
        
        if ($formUser->isSubmitted() && $formUser->isValid()) { 
            $data = $formUser->getData();
            
            $entityManager = $this->getDoctrine()->getManager();

            $user = new User();

            $user->setUsername($data->getUsername());
            $user->setCnp($data->getCnp());
            
            $user->setPassword($password_encoder->encodePassword($user, $data->getPassword()));

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash("registerSucces","You'r account was created!");

            return $this->redirect($this->generateUrl("app_login"));
        }

        return $this->render('register/index.html.twig', [
            'registerForm' => $formUser->createView()
        ]);
    }
}
