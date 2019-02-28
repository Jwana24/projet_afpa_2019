<?php

namespace App\Form;

use App\Entity\Members;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class MemberType extends AbstractType
{
    private $member;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->member = $options['data'];
        $builder
            ->add('last_name')
            ->add('first_name')
            ->add('username')
            ->add('password', RepeatedType::class, [ // we want to the user confirm is password in an input 'confirm password' : we indicate to this input is a repeated type compared to the input's password
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe ne correspond pas',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => false,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmation du mot de passe'],
            ])
            ->add('mail')
            ->add('description')
            ->add('avatar', FileType::class, ['label' => 'Avatar',
            'data_class' => null, 'required' => false]);

            $builder
            ->get('password')
            ->addModelTransformer(new CallbackTransformer(
                function ($file)
                {
                    return $file;
                },

                function ($file)
                {
                    if($file === null)
                    {
                        return $this->member->getPassword();
                    }
                    return $file;
                }
            ));

            $builder
            ->get('avatar')
            ->addModelTransformer(new CallbackTransformer(
                function ($file)
                {
                    return $file;
                },
                
                function ($file)
                {
                    if($file === null)
                    {
                        return $this->member->getAvatar();
                    }
                    return $file;
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Members::class,
            'csrf_protection' => false
        ]);
    }
}
