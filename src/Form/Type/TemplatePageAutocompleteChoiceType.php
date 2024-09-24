<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Form\Type;

final class TemplatePageAutocompleteChoiceType extends AbstractTemplateAutocompleteChoiceType
{
    public function getBlockPrefix(): string
    {
        return 'sylius_template_page_autocomplete_choice';
    }
}
