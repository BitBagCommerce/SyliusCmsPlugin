<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Form\Type\Autocomplete;

use Sylius\CmsPlugin\Repository\TemplateRepositoryInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;

#[AsEntityAutocompleteField(
    alias: 'sylius_admin_cms_template_block',
    route: 'sylius_admin_entity_autocomplete',
)]
final class TemplateBlockAutocompleteType extends AbstractTemplateAutocompleteType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefault('query_builder', function (TemplateRepositoryInterface $er) {
            $qb = $er->createQueryBuilder('o');

            $qb->andWhere('o.type = :type')
                ->setParameter('type', 'block')
            ;

            return $qb;
        });
    }

    public function getBlockPrefix(): string
    {
        return 'sylius_admin_cms_template_block_autocomplete';
    }
}
