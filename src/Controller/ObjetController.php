<?php

namespace App\Controller;

use App\Entity\Objet;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Form\CategorieFilterType;
use App\Form\ObjetType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ObjetController extends AbstractController
{
    #[Route('/objet', name: 'app_objet')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {   
        $form = $this->createForm(CategorieFilterType::class);
        $form->handleRequest($request);

        $objet = $entityManager->getRepository(Objet::class)->findAll();

        if ($form->isSubmitted() && $form->isValid()) {
            $selectedCategorie = $form->getData()['nom'];

            if ($selectedCategorie) {
                $objet = $entityManager->getRepository(Objet::class)->findByCategorie($selectedCategorie);
            }

        }
        
        return $this->render('objet/index.html.twig', [
            'form' => $form->createView(),
            'objets' => $objet,

        ]);
    }

    /**
     * Crée un nouvel objet
     */
    #[Route('/objet/create', name: 'app_objet_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $objet = new Objet();

        $form = $this->createForm(ObjetType::class, $objet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($objet->getUser() === null) {
                $objet->setUser($this->getUser());
            }
            $em->persist($objet);
            $em->flush();

            $this->addFlash('success', 'L\'objet a été créé avec succès !');

            return $this->redirectToRoute('app_objet');
        }

        return $this->render('objet/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * Show détails of an objet
     */
    #[Route('/objet/show/{id}', name: 'app_objet_show')]
    public function show(int $id, EntityManagerInterface $entityManager): Response
    {
        $objet = $entityManager->getRepository(Objet::class)->find($id);
    
        if (!$objet) {
            throw $this->createNotFoundException("L'objet avec l'ID $id n'existe pas.");
        }
    
        return $this->render('objet/show.html.twig', [
            'objet' => $objet,
        ]);
    }
    
    /**
     * Edit an objet
     */
    #[Route('/objet/edit/{id}', name: 'app_objet_edit')]
    public function edit(Objet $objet, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ObjetType::class, $objet);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
    
            $this->addFlash('success', "L'objet a été modifié avec succès !");
    
            return $this->redirectToRoute('app_objet');
        }
    
        return $this->render('objet/create.html.twig', [
            'form' => $form->createView(),
            'objet' => $objet,
        ]);
    }
    
    #[Route('/objet/delete/{id}', name: 'app_objet_delete', methods: ['POST'])]
    public function delete(Request $request, Objet $objet, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $objet->getId(), $request->request->get('_token'))) {
            $entityManager->remove($objet);
            $entityManager->flush();
            $this->addFlash('success', "L'objet a été supprimé avec succès !");
        }
    
        return $this->redirectToRoute('app_objet');
    }


    #[Route('/objet/{id}/emprunter', name: 'app_objet_emprunter', methods: ['POST'])]
    public function emprunter(Objet $objet, EntityManagerInterface $entityManager, Request $request): RedirectResponse
    {
        $user = $this->getUser();
    
        // Vérifier si l'utilisateur est connecté
        if (!$user) {
            $this->addFlash('danger', 'Vous devez être connecté pour emprunter un objet.');
            return $this->redirectToRoute('app_login'); // Redirige vers la page de connexion
        }
    
        // Vérifier si l'objet est disponible
        if (!$objet->isDisponible()) {
            $this->addFlash('warning', 'Cet objet n\'est plus disponible.');
            return $this->redirectToRoute('app_objet_show', ['id' => $objet->getId()]);
        }
    
        // Mettre à jour les informations de l'emprunt
        $objet->setEmprunteur($user);
        $objet->setDateEmprunt(new \DateTime());
        $objet->setDisponible(false);
    
        $entityManager->flush(); // Enregistrer les modifications
    
        $this->addFlash('success', 'Votre demande d\'emprunt a été enregistrée !');
    
        return $this->redirectToRoute('app_objet');
    
}
}