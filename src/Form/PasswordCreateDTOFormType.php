<?php
declare(strict_types=1);
namespace App\Form;

use App\DTO\PasswordCreateDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PasswordCreateDTOFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'login',
                TextType::class,
                [
                    'label'    => "login",
                    'required' => true,
                ]
            )
            ->add(
                'webAddress',
                TextType::class,
                [
                    'label'    => "adres",
                    'required' => true,
                ]
            )
            ->add(
                'userPassword',
                RepeatedType::class,
                [
                    'type'            => PasswordType::class,
                    'invalid_message' => 'W polach "Hasło" i "Powtórz hasło" powinna być ta sama wartość. ',
                    'first_options'   => [
                        'label' => 'Twoje haslo',
                        'attr'  => [
                            'placeholder'  => 'Wpisz',
                            'autocomplete' => 'new-password',
                        ],
                    ],
                    'second_options'  => [
                        'label' => 'Powtórz hasło',
                        'attr'  => [
                            'placeholder'  => 'Wpisz',
                            'autocomplete' => 'new-password',
                        ],
                    ],
                ]
            )
            ->add(
                'password',
                RepeatedType::class,
                [
                    'type'            => PasswordType::class,
                    'invalid_message' => 'W polach "Hasło" i "Powtórz hasło" powinna być ta sama wartość. ',
                    'first_options'   => [
                        'label' => 'Hasło',
                        'attr'  => [
                            'placeholder'  => 'Wpisz',
                            'autocomplete' => 'new-password',
                        ],
                    ],
                    'second_options'  => [
                        'label' => 'Powtórz hasło',
                        'attr'  => [
                            'placeholder'  => 'Wpisz',
                            'autocomplete' => 'new-password',
                        ],
                    ],
                ]
            )  ->add(
                'description',
                TextType::class,
                [
                    'label'    => "opis",
                    'required' => true,
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => PasswordCreateDTO::class,
            ]
        );
    }
}
