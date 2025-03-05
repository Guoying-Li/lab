<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\EditProfileType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserController extends AbstractController
{

    #[Route(path: '/user', name: 'app_user')]
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

/**
 * @Route("/user",name="user_add")
 */ 
    public function addUser(UserRepository $userRepository): Response
    {
    return $this->render('user/add.html.twig', [
        'users' => $userRepository->findBy([],['nom'=>'ASC']),
    ]);
    }
    /**
     * @Route("/user/delete/{id}", name="user_delete", requirements={"id":"\d+"})
     */
    public function delete(User $user=null, EntityManagerInterface $em): Response
    {
        if($user){
            $em->remove($user);
            $em->flush();
            $this->addFlash("success", "Utilisateur".$user->getNom()." a été supprimé !");
        }
        else $this->addFlash("error", "pas de user correspondant...");
        return $this->redirectToRoute("pret");
    }


/**
 * @Route("/user/profil/modifier", name="user_profil_modifier")
 */
    public function editProfile(Request $request)
    {   
        $user = $this->getUser();
        $form = $this->createForm(EditProfileType::class, $this->getUser());
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('message', 'Profil mis à jour');
            return $this->redirectToRoute('user');
        }
    return $this->render('user/editprofile.html.twig',[
        'form' => $form->createView(),
    ]);
    }

    /**
     * @Route("/user/pass/modifier", name="user_pass_modifier")
     */
    public function editPass(Request $request, UserPasswordHasherInterface $passwordHasher)
    {
        if($request->isMethod('POST')){
            $em = $this->getDoctrine()->getManager();

            $user = $this->getUser();

            // On vérifie si les 2 mots de passe sont identiques
            if($request->request->get('pass') == $request->request->get('pass2')){
                $user->setPassword($passwordHasher->hashPassword($user, $request->request->get('pass')));
                $em->flush();
                $this->addFlash('message', 'Mot de passe mis à jour avec succès');

                return $this->redirectToRoute('user');
            }else{
                $this->addFlash('error', 'Les deux mots de passe ne sont pas identiques');
            }
        }

        return $this->render('user/editpass.html.twig');
    }


}