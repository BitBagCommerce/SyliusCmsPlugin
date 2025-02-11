<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Form\Type;

use BitBag\SyliusCmsPlugin\Form\Strategy\Wysiwyg\WysiwygStrategyInterface;
use BitBag\SyliusCmsPlugin\Resolver\WysiwygStrategyResolverInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class WysiwygType extends AbstractType
{
    private WysiwygStrategyInterface $strategy;

    public function __construct(private WysiwygStrategyResolverInterface $strategyResolver)
    {
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $this->strategy->configureOptions($resolver);
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $this->strategy->buildView($view, $form, $options);
    }

    public function getParent(): string
    {
        return $this->strategy->getParent();
    }

    public function getBlockPrefix(): string
    {
        return $this->strategy->getBlockPrefix();
    }

    public function setStrategy(string $strategy): void
    {
        $this->strategy = $this->strategyResolver->getStrategy($strategy);
    }
}
