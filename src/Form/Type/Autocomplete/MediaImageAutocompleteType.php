<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Form\Type\Autocomplete;

use Sylius\CmsPlugin\Repository\MediaRepositoryInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;

#[AsEntityAutocompleteField(
    alias: 'sylius_admin_cms_media_image',
    route: 'sylius_admin_entity_autocomplete',
)]
final class MediaImageAutocompleteType extends AbstractMediaAutocompleteType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefault('query_builder', function (MediaRepositoryInterface $er) {
            $qb = $er->createQueryBuilder('o');

            $qb->andWhere('o.type = :type')
                ->setParameter('type', 'image')
            ;

            return $qb;
        });
    }

    public function getBlockPrefix(): string
    {
        return 'sylius_admin_cms_media_image_autocomplete';
    }
}
