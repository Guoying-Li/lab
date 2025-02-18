<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Utilisateur')
            ->setEntityLabelInPlural('Utilisateurs')
            ->setPageTitle('index', 'Gestion des utilisateurs')
            ->setPageTitle('edit', fn (User $user) => sprintf('Edition de <b>%s</b>', $user->getUserIdentifier()))
            ->setPageTitle('new', 'Création d\'un utilisateur')
            ->setPaginatorPageSize(10);
            
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                 ->hideOnForm(),
            TextField::new('email')
                 ->hideOnForm(),
            TextField::new('nom'),
            TextField::new('prenom'),
            ArrayField::new('roles'),
            DateTimeField::new('createdAt')
                 ->hideOnForm(),
        ];
    }
    
}
