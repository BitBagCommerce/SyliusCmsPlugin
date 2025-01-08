<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Form\Type\Autocomplete;

use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;

#[AsEntityAutocompleteField(
    alias: 'sylius_admin_cms_media',
    route: 'sylius_admin_entity_autocomplete',
)]
final class MediaAutocompleteType extends AbstractMediaAutocompleteType
{
    public function getBlockPrefix(): string
    {
        return 'sylius_admin_cms_media_autocomplete';
    }
}
