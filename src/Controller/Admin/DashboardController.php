<?php

namespace App\Controller\Admin;

use App\Entity\Pret;
use App\Entity\User;
use App\Entity\Objet;
use App\Entity\Modalite;
use App\Entity\Categorie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
   // #[IsGranted('ROLE_ADMIN')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Emprunthèque - Admin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Categories', 'fas fa-list', Categorie::class);
        yield MenuItem::linkToCrud('Modalités', 'fas fa-outdent', Modalite::class);
        yield MenuItem::linkToCrud('Objets', 'fas fa-object-ungroup', Objet::class);
        yield MenuItem::linkToCrud('Prêts', 'fas fa-rotate', Pret::class);
    }
}
