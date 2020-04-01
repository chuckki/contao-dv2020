<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'email',
            EmailType::class,
            [
                'label'       => false,
                'attr'        => ['placeholder' => 'E-Mail-Adresse'],
                'constraints' => [
                    new Regex(
                        [
                            'pattern' => "/(@hhu.de|@uni-duesseldorf.de)$/",
                            'message' => 'Benutzen Sie ausschliesslich Ihre Uni-E-Mailadresse.',
                        ]
                    ),
                ],
            ]
        )->add(
            'agreeTerms',
            CheckboxType::class,
            [
                'label'       => 'Hiermit akzeptiere ich die Datenschutzbestimmung.',
                'mapped'      => false,
                'constraints' => [
                    new IsTrue(
                        [
                            'message' => 'Sie sollten unseren Bedingungen zustimmen.',
                        ]
                    ),
                ],
            ]
        )->add(
            'password',
            RepeatedType::class,
            [
                'type'            => PasswordType::class,
                'invalid_message' => 'Die Passwörter müssen übereinstimmen.',
                'options'         => ['attr' => ['class' => 'password-field']],
                'required'        => true,
                'first_options'   => [
                    'label' => false,
                    'attr'  => ['placeholder' => 'Passwort'],
                ],
                'second_options'  => [
                    'label' => false,
                    'attr'  => ['placeholder' => 'Passwort wiederholen'],
                ],
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped'          => false,
                'constraints'     => [
                    new NotBlank(
                        [
                            'message' => 'Bitte Passwort eingeben',
                        ]
                    ),
                    new Length(
                        [
                            'min'        => 6,
                            'minMessage' => 'Das Passwort sollte mindestens aus {{ limit }} Zeichen bestehen',
                            // max length allowed by Symfony for security reasons
                            'max'        => 4096,
                        ]
                    ),
                ],
            ]
        );
    }

}
