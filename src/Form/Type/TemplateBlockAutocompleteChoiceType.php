<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Form\Type;

final class TemplateBlockAutocompleteChoiceType extends AbstractTemplateAutocompleteChoiceType
{
    public function getBlockPrefix(): string
    {
        return 'sylius_template_block_autocomplete_choice';
    }
}
