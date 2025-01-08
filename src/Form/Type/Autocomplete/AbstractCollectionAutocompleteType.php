<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Form\Type\Autocomplete;

use Sylius\CmsPlugin\Entity\Collection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\BaseEntityAutocompleteType;

abstract class AbstractCollectionAutocompleteType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class' => Collection::class,
            'choice_label' => 'name',
            'choice_value' => 'code',
        ]);
    }

    public function getParent(): string
    {
        return BaseEntityAutocompleteType::class;
    }
}
