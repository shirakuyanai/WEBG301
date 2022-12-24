<?php

namespace App\Form;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $roles = $this->getParent();

        $builder
            ->add('username')
            ->add('email', EmailType::class)
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
            ->add('firstname', TextType::class, [
                'required' => false,
            ])
            ->add('lastname', TextType::class, [
                'required' => false,
            ])
            ->add('phone', TelType::class,[
                'required' => false,
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 9,
                        'max' => 10,
                        'minMessage' => 'Invalid phone number',
                        'maxMessage' => 'Invalid phone number',
                        // max length allowed by Symfony for security reasons
                    ]),
                ]
            ])
            ->add('address_1', TextType::class, [
                'required' => false,
            ])
            ->add('address_2', TextType::class, [
                'required' => false,
            ])
            ->add('address_3', TextType::class, [
                'required' => false,
            ])
            ->add('address_4', TextType::class, [
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
