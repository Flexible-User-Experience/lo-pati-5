<?php

namespace App\Form\Type;

use App\Entity\NewsletterUser;
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
                        'class' => 'bg-transparent border-2 rounded-0 text-uppercase',
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
                        'class' => 'bg-transparent border-2 rounded-0 text-uppercase',
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
                        'class' => 'bg-transparent border-2 rounded-0 text-uppercase',
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
                        'class' => 'bg-transparent border-2 rounded-0 text-uppercase',
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
