<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Message;
use App\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $isPost = $options['isPost'];

        if ($isPost) {
            $builder
                ->add('title')
                ->add('category', EntityType::class, [
                    'class' => Category::class,
                    'choice_label' => 'name',
                    'query_builder' => function (CategoryRepository $categoryRepository) {
                        return $categoryRepository->createQueryBuilder('c')
                            ->orderBy('c.name', 'ASC');
                    }
                ])
                ->add('image', FileType::class, [
                    // dire a symfony que l'on va gérer nous meme le query builder
                    'mapped' => false,
                ]);
        }

        $builder
            ->add('content', TextareaType::class, [
                'label' => 'Content',
                'attr' => [
                    'rows' => 5, // Définit le nombre de lignes visibles par défaut
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
            'isPost' => true,
        ]);
    }
}
