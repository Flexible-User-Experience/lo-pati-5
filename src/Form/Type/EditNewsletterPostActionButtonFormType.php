<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class EditNewsletterPostActionButtonFormType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefined(
                [
                    'text',
                    'url',
                    'css',
                    'icon',
                ]
            )
            ->setDefaults(
                [
                    'text' => 'hack',
                    'url' => '#',
                    'css' => 'btn btn-primary',
                    'icon' => 'fa fa-edit',
                ]
            )
        ;
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        if (array_key_exists('text', $options) && array_key_exists('url', $options) && array_key_exists('css', $options) && array_key_exists('icon', $options)) {
            $view->vars['text'] = $options['text'];
            $view->vars['url'] = $options['url'];
            $view->vars['css'] = $options['css'];
            $view->vars['icon'] = $options['icon'];
        }
    }

    public function getBlockPrefix(): string
    {
        return 'edit_newsletter_post_action_button';
    }
}
