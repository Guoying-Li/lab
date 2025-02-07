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
     * Create a new objet
     *
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     */
    #[Route('/objet/create', name: 'app_objet_create')]
 
    public function create(Objet $objet = null, Request $request, EntityManagerInterface $em)
    {
        $categories = $em->getRepository(Categorie::class)->findAll();
        if ($objet == null)
            $objet = new Objet();

        $form = $this->createForm(ObjetType::class, $objet, [
            'categories' => $categories,
        ]);

       
        $objet = new Objet();
        $form = $this->createForm(ObjetType::class, $objet);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($objet);
            $em->flush();
    
            return $this->redirectToRoute('app_objet_index');
        }
    
        return $this->render('objet/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * Show détails of an objet
     *
     * @param string $titre
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/objet/show', name: 'app_objet_show')]
    public function show(string $titre, EntityManagerInterface $entityManager): Response
    {
        $objet = $entityManager->getRepository(Objet::class)->findOneBy(['title' => $titre]);

        if (!$objet) {
            throw $this->createNotFoundException('No objet found for this titre');
        }

        return $this->render('objet/show.html.twig', [
            'objet' => $objet,
        ]);
    }

    
        /**
     * @Route("/objet/delete/{id}", name="objet_delete", requirements={"id"="\d+"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Objet $objet = null, EntityManagerInterface $em): Response
    {
        if ($objet) {
            $em->remove($objet);
            $em->flush();
            $this->addFlash("success", "L'objet" . $objet->getTitre() . "a été supprimé !");
        } else $this->addFlash("error", "pas d'objet correspondant...");


        return $this->redirectToRoute("home");
    }
}
