<?php

namespace App\Controller;

use App\Entity\Objet;
use Doctrine\ORM\EntityManager;
use App\Form\CategorieFilterType;
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
            'objet' => $objet,

        ]);
    }
}
