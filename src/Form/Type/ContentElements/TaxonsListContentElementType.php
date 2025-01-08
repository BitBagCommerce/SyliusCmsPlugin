<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Form\Type\ContentElements;

use Sylius\Bundle\AdminBundle\Form\Type\CatalogPromotionScope\ForTaxonsScopeConfigurationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

final class TaxonsListContentElementType extends AbstractType
{
    public const TYPE = 'taxons_list';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(self::TYPE, ForTaxonsScopeConfigurationType::class, [
                'label' => false,
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'sylius_cms_content_elements_' . self::TYPE;
    }
}
