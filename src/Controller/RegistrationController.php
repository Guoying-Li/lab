<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use App\Security\UserAuthenticator;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request, 
        UserPasswordHasherInterface $userPasswordHasher, 
        UserAuthenticatorInterface $userAuthenticator, 
        UserAuthenticator $authenticator, 
        EntityManagerInterface $entityManager
    ): Response {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                // Hacher le mot de passe
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );

                // Sauvegarder l'utilisateur en base de données
                $entityManager->persist($user);
                $entityManager->flush();

                // Ajouter un message de succès
                $this->addFlash('success', 'Votre compte a été créé avec succès !');

                // Connexion automatique après l'inscription (optionnel)
                return $userAuthenticator->authenticateUser(
                    $user,
                    $authenticator,
                    $request
                ) ?? $this->redirectToRoute('app_objet'); // Redirection après connexion

            } catch (\Exception $e) {
                $this->addFlash('error', 'Une erreur est survenue lors de l’inscription.');
            }
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}

