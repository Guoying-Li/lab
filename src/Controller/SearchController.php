<?php

namespace App\Controller;

use App\Repository\CourseRepository;
use App\Repository\ObjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class SearchController extends AbstractController
{

    /**
     * Create a form to search in the Course index page
     *
     * @return Response
     */
    #[Route('/search', name: 'app_search')]
    public function searchBar(): Response
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('handleSearch'))
            ->add('query', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez un mot-clé'
                ]
            ])
            ->add('recherche', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-search'
                ]
            ])
            ->getForm();

        return $this->render('search/searchBar.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Manage the search
     *
     * @param Request $request
     * @param CourseRepository $repo
     * @return Response
     */
    #[Route('/handleSearch', name: 'handleSearch')]
    public function handleSearch(Request $request, ObjetRepository $repo): Response
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('handleSearch'))
            ->add('query', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez un mot-clé'
                ]
            ])
           
            ->getForm();
        

        $form->handleRequest($request);

        $query = $form->getData()['query']; //$request->request->get('form')['query'] ?? '';

        $objets = [];
    
        if ($query) {
            $objets = $repo->findObjetsByTitle($query);
        }
      
        return $this->render('search/index.html.twig', [
            'objets' => $objets,
            
        ]);
    }
    
}