<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Form\Type\ContentElements;

use Sylius\Bundle\AdminBundle\Form\Type\TaxonAutocompleteType;
use Sylius\Bundle\ResourceBundle\Form\DataTransformer\ResourceToIdentifierTransformer;
use Sylius\Bundle\TaxonomyBundle\Form\Type\TaxonAutocompleteChoiceType;
use Sylius\CmsPlugin\Form\DataTransformer\ContentElementDataTransformerChecker;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\ReversedTransformer;

final class ProductsCarouselByTaxonContentElementType extends AbstractType
{
    public const TYPE = 'products_carousel_by_taxon';

    public function __construct(
        private RepositoryInterface $taxonRepository,
        private ContentElementDataTransformerChecker $contentElementDataTransformerChecker,
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(self::TYPE, TaxonAutocompleteType::class, [
                'label' => 'sylius_cms.ui.taxon',
            ])
        ;

        $builder->get(self::TYPE)->addModelTransformer(
            new ReversedTransformer(new ResourceToIdentifierTransformer($this->taxonRepository, 'code')),
        );

        $this->contentElementDataTransformerChecker->check($builder, $this->taxonRepository, self::TYPE);
    }

    public function getBlockPrefix(): string
    {
        return 'sylius_cms_content_elements_' . self::TYPE;
    }
}
