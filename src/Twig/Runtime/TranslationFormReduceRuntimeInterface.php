<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Twig\Runtime;

use Symfony\Component\Form\FormView;

interface TranslationFormReduceRuntimeInterface
{
    public function reduceTranslationForm(FormView $form, array $fields): array;
}
