<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Form\Strategy\Wysiwyg;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractWysiwygStrategy implements WysiwygStrategyInterface
{
    public function configureOptions(OptionsResolver $resolver): void
    {
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
    }

    public function getParent(): string
    {
        return TextareaType::class;
    }

    public function getBlockPrefix(): string
    {
        return 'bitbag_wysiwyg';
    }
}
