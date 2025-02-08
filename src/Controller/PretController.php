<?php

namespace App\Controller;

use App\Entity\Pret;
use App\Entity\Objet;
use App\Form\PretType;
use Doctrine\ORM\EntityManager;
use App\Repository\PretRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PretController extends AbstractController
{
    /**
     * @Route("/pret",name="pret")

     */
    public function index(PretRepository $pretRepository, UserRepository $userRepository): Response
    {
        return $this->render('pret/index.html.twig', [
            'prets' => $pretRepository->findBy([], ['dateDePret' => "DESC"]),
            'users' => $userRepository->findBy([], ['nom' => "ASC"]),
        ]);
    }

    /**
     * @Route("/pret/add", name="pret_add")

     */
    public function addPret(Request $request, EntityManagerInterface $em)
    {
        $pret = new Pret();

        $form = $this->createForm(PretType::class, $pret);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $pret->setUser($this->getUser());
            $em->persist($pret);
            $em->flush();
            $this->addFlash('success', 'L\'emprunt a bien été enregistré !');
            return $this->redirectToRoute('home');
        }
        return $this->render('pret/add.html.twig', [
            'formAddPret' => $form->createView(),
            'editMode' => $pret->getId() !== null
        ]);
    }

    /**
     * @Route("/pret/edit/{id}", name="pret_edit")

     */
    public function editPret(Pret $pret, Request $request, EntityManagerInterface $em)
    {

        $form = $this->createForm(PretType::class, $pret);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();
            $this->addFlash('success', 'L\'emprunt a bien été modifié !');
            return $this->redirectToRoute('pret');
        }
        return $this->render('pret/add.html.twig', [
            'formAddPret' => $form->createView(),
            'editMode' => $pret->getId()
        ]);
    }
    /**
     * @Route("/pret/delete/{id}", name="pret_delete", requirements={"id":"\d+"})

     */
    public function delete(Pret $pret = null, EntityManagerInterface $em): Response
    {
        if ($pret) {
            $em->remove($pret);
            $em->flush();
            $this->addFlash("success", "Le prêt" . $pret->getId() . " a été supprimé !");
        } else $this->addFlash("error", "pas de prêt correspondant...");
        return $this->redirectToRoute("pret");
    }
}