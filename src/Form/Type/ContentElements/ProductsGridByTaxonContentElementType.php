<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Form\Type\ContentElements;

use BitBag\SyliusCmsPlugin\Form\DataTransformer\ContentElementDataTransformerChecker;
use Sylius\Bundle\ResourceBundle\Form\DataTransformer\ResourceToIdentifierTransformer;
use Sylius\Bundle\TaxonomyBundle\Form\Type\TaxonAutocompleteChoiceType;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\ReversedTransformer;

final class ProductsGridByTaxonContentElementType extends AbstractType
{
    public const TYPE = 'products_grid_by_taxon';

    public function __construct(
        private RepositoryInterface $taxonRepository,
        private ContentElementDataTransformerChecker $contentElementDataTransformerChecker,
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(self::TYPE, TaxonAutocompleteChoiceType::class, [
                'label' => 'sylius_cms_plugin.ui.taxon',
                'choice_value' => 'code',
                'resource' => 'sylius.taxon',
            ])
        ;

        $builder->get(self::TYPE)->addModelTransformer(
            new ReversedTransformer(new ResourceToIdentifierTransformer($this->taxonRepository, 'code')),
        );

        $this->contentElementDataTransformerChecker->check($builder, $this->taxonRepository, self::TYPE);
    }

    public function getBlockPrefix(): string
    {
        return 'sylius_cms_plugin_content_elements_' . self::TYPE;
    }
}
