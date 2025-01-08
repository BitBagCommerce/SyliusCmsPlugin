<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Form\Type\Autocomplete;

use Sylius\CmsPlugin\Repository\CollectionRepositoryInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;

#[AsEntityAutocompleteField(
    alias: 'sylius_admin_cms_collection_page',
    route: 'sylius_admin_entity_autocomplete',
)]
final class CollectionPageAutocompleteType extends AbstractCollectionAutocompleteType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefault('query_builder', function (CollectionRepositoryInterface $er) {
            $qb = $er->createQueryBuilder('o');

            $qb->andWhere('o.type = :type')
                ->setParameter('type', 'page')
            ;

            return $qb;
        });
    }

    public function getBlockPrefix(): string
    {
        return 'sylius_admin_cms_collection_page_autocomplete';
    }
}
