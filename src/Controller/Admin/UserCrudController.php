<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\HiddenField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

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
        yield HiddenField::new('id')->hideOnForm()->hideOnIndex();
        yield TextField::new('email')
            ->setLabel('email');
        yield TextField::new('nom')
            ->setLabel('Nom');
        yield TextField::new('prenom')
            ->setLabel('Prénom');
        yield TextField::new('password')
            ->hideOnIndex()
            ->setLabel('Password')
            ->setFormType(PasswordType::class);
        yield TextField::new('telephone')
            ->setLabel('Téléphone');
        yield ArrayField::new('roles')
            ->setLabel('Rôles');
        yield DateField::new('created_at')
            ->setLabel('Créé le')
            ->setFormat('dd/MM/yyyy');
    
    }
    
}
