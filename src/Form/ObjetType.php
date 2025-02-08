<?php

namespace App\Form;
use App\Entity\Objet;
use App\Entity\Modalite;
use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use App\Repository\ModaliteRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ObjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imageFile', VichImageType::class, [
                'label' => "Image de l'objet",
                'label_attr' => ['class' => 'form-label mt-4 fw-bold'],
                'required' => true,
                'download_uri' => false,
            ])
            ->add('titre', TextType::class, [
                'label' => 'Titre',
                'label_attr' => ['class' => 'form-label fw-bold'],
                'attr' => ['class' => 'form-control'],
            ])
            ->add('categories', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom',
                'multiple' => true, // Sélection multiple
                'expanded' => false, // Liste déroulante
                'query_builder' => function (CategorieRepository $repo) {
                    return $repo->createQueryBuilder('c')->orderBy('c.nom', 'ASC');
                },
                'label' => 'Catégories',
                'label_attr' => ['class' => 'form-label fw-bold'],
                'attr' => ['class' => 'form-select'],
            ])
            ->add('modalite', EntityType::class, [
                'class' => Modalite::class,
                'choice_label' => 'nom',
                'multiple' => false,    // Sélection unique
                'expanded' => false, // Liste déroulante
                'query_builder' => function (ModaliteRepository $modalite) {
                    return $modalite->createQueryBuilder('m')->orderBy('m.nom', 'ASC');
                },
                'label' => 'Modalités',
                'label_attr' => ['class' => 'form-label fw-bold'],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'label_attr' => ['class' => 'form-label fw-bold'],
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 5, // Ajusté à 5 pour un meilleur affichage
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Objet::class, // L'objet à lier
        ]);
    }
}
