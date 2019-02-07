<?php

namespace App\Form;

use App\Entity\Articles;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticleType extends AbstractType
{
    private $article;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->article = $options['data'];
        $builder
            ->add('title_article', TextType::class, [
                'label'=> 'Titre de l\'article'
            ])
            ->add('text_article', TextareaType::class, [
                'label'=> 'Contenu de l\'article'
            ])
            ->add('image', FileType::class, ['label' => 'Image',
            'data_class' => null, 'required' => true]);

        $builder
        ->get('image')
        ->addModelTransformer(new CallbackTransformer(
            function ($file)
            {
                return $file;
            },
            
            function ($file)
            {
                if($file === null)
                {
                    return $this->article->getImage();
                }
                return $file;
            }
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }
}
