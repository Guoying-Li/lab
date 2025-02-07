<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Objet;
use App\Entity\Modalite;
use App\Entity\Categorie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ObjetType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('imageFile', VichImageType::class, [
            'label' => 'Image du objet',
            'label_attr'=> [
                'class' => 'form-label mt-4 fw-bold'
            ],
            'required'=> true,
            'download_uri' => false,
        ])
        ->add('titre', TextType::class)
        ->add('categories', EntityType::class, [
            'class' => Categorie::class,
            'choice_label' => 'nom',
            'multiple' => true,
            'expanded' => true,
            'choices' => $options['categories'],
        ])
           
            ->add('description', TextType::class
            , [
                'attr' => ['rows' => 15], // Définit le nombre de lignes dans le textarea
            ])


            ->add('modalite', EntityType::class, [
                'class' => Modalite::class,
                'multiple' => false,
                'expanded' => true,
                'choice_label' => function (Modalite $modalite) {
                    return $modalite;
                },
            ])
            ->add('categories', EntityType::class, [
                'class' => Categorie::class,
                'multiple' => true,
                'expanded' => true,
                'choice_label' => function (Categorie $categorie) {
                    return $categorie;
                },
            ])

            ->add('valider', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Objet::class,
            'categories' => [],
        ]);
    }
}