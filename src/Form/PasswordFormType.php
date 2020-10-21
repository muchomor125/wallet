<?php
declare(strict_types=1);
namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => User::class,
            ]
        );
    }
}
