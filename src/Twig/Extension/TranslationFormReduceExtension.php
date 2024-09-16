<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Twig\Extension;

use Sylius\CmsPlugin\Twig\Runtime\TranslationFormReduceRuntimeInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class TranslationFormReduceExtension extends AbstractExtension
{
    public function __construct(private TranslationFormReduceRuntimeInterface $translationFormReduce)
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'translation_form_reduce',
                [$this->translationFormReduce, 'reduceTranslationForm'],
                ['is_safe' => ['html']],
            ),
        ];
    }
}
