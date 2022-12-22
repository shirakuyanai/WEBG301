<?php

namespace App\Form;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $roles = $this->getParent();

        $builder
            ->add('username')
            ->add('email')
            ->add('roles', ChoiceType::class, array(
                'attr'  =>  array('class' => 'form-control',
                'style' => 'margin:5px 0;'),
                'choices' => 
                array
                (
                    'Admin' => array
                    (
                        'Yes' => "ROLE_ADMIN",
                    ),

                    'User' => array
                    (
                        'Yes' => "ROLE_USER"
                    ),
                ) 
                ,
                'multiple' => true,
                'required' => true,
                )
            )
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
