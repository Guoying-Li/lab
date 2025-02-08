<?php

namespace App\Controller;

use App\Entity\Objet;
use App\Entity\Categorie;
use Doctrine\ORM\EntityManager;
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
    

    
    #[Route('/objet/delete/{id}', name: 'app_objet_delete', methods: ['POST'])]
    public function delete(Request $request, Objet $objet, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $objet->getId(), $request->request->get('_token'))) {
            $entityManager->remove($objet);
            $entityManager->flush();
            $this->addFlash('success', "L'objet a été supprimé avec succès !");
        }
    
        return $this->redirectToRoute('app_objet_index');
    }
    
}
