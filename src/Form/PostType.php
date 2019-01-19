<?php

namespace App\Form;

use App\Entity\Posts;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title_post')
            ->add('categorie', ChoiceType::class, array(
                'choices'  => array(
                    'mammifères' => 'mammifères',
                    'reptiles' => 'reptiles',
                    'amphibiens' => 'amphibiens',
                    'oiseaux' => 'oiseaux',
                    'poissons' => 'poissons'
                )
            ))
            ->add('text_post')
            ->add('Envoyer', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Posts::class,
        ]);
    }
}
