<?php

namespace App\Form\Type;

use App\Entity\NewsletterUser;
use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaV3Type;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints\IsTrueV3;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class NewsletterSubscriptionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'label' => false,
                    'required' => true,
                    'attr' => [
                        'placeholder' => 'newsletter.form.name',
                        'class' => 'lp-c-light-grey bg-transparent border-2 rounded-0',
                    ],
                ]
            )
            ->add(
                'email',
                EmailType::class,
                [
                    'label' => false,
                    'required' => true,
                    'attr' => [
                        'placeholder' => 'newsletter.form.email',
                        'class' => 'lp-c-light-grey bg-transparent border-2 rounded-0',
                    ],
                ]
            )
            ->add(
                'postalCode',
                TextType::class,
                [
                    'label' => false,
                    'required' => false,
                    'attr' => [
                        'placeholder' => 'newsletter.form.zip',
                        'class' => 'lp-c-light-grey bg-transparent border-2 rounded-0',
                    ],
                ]
            )
            ->add(
                'phone',
                TextType::class,
                [
                    'label' => false,
                    'required' => false,
                    'attr' => [
                        'placeholder' => 'newsletter.form.phone',
                        'class' => 'lp-c-light-grey bg-transparent border-2 rounded-0',
                    ],
                ]
            )
            ->add(
                'recaptcha',
                EWZRecaptchaV3Type::class,
                [
                    'action_name' => 'newsletter',
                    'mapped' => false,
                    'constraints' => [
                        new IsTrueV3(),
                    ],
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NewsletterUser::class,
        ]);
    }
}
