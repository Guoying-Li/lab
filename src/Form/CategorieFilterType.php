<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Objet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CategorieFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {    
        $builder
        ->add('nom', EntityType::class, [
            'class' => Categorie::class,
            'choice_label' => 'name', 
            'placeholder' => 'Choisir une catégorie',
            'required' => false,
        ]);
}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            
        ]);
    }
}
