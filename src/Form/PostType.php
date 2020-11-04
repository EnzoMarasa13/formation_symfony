<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Post;
use App\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'help' => 'Saisissez au moins 3 caractères',
                'label' => 'Titre',
                'attr' => ['data-coucou' => 'test']
            ])
            ->add('description', TextareaType::class)
            ->add('isEnabled')
            ->add('category', EntityType::class, [
                'choice_label' => 'idTitle',
                'class' => Category::class,
                'placeholder' => '',
                'query_builder' => function(CategoryRepository $cr) {
                    return $cr->findFirst();
                }
            ])
            //->add('category', CategoryType::class)
            ->add('category', null, ['choice_label' => 'idTitle'])
            ->add('tags', null, ['by_reference' => false, 'expanded' => true])
            /*
             *
             ->add('tags', CollectionType::class, [
                'entry_type' => TagType::class,
                'prototype' => true,
                'allow_add' => true
            ])
            */
            //->add('valid', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
