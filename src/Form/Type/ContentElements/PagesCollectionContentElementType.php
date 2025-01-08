<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Form\Type\ContentElements;

use Sylius\Bundle\ResourceBundle\Form\DataTransformer\ResourceToIdentifierTransformer;
use Sylius\CmsPlugin\Form\DataTransformer\ContentElementDataTransformerChecker;
use Sylius\CmsPlugin\Form\Type\Autocomplete\CollectionPageAutocompleteType;
use Sylius\CmsPlugin\Form\Type\PageCollectionAutocompleteChoiceType;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\ReversedTransformer;

final class PagesCollectionContentElementType extends AbstractType
{
    public const TYPE = 'pages_collection';

    public function __construct(
        private RepositoryInterface $collectionRepository,
        private ContentElementDataTransformerChecker $contentElementDataTransformerChecker,
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(self::TYPE, CollectionPageAutocompleteType::class, [
                'label' => 'sylius_cms.ui.content_elements.type.' . self::TYPE,
            ])
        ;

        $builder->get(self::TYPE)->addModelTransformer(
            new ReversedTransformer(new ResourceToIdentifierTransformer($this->collectionRepository, 'code')),
        );

        $this->contentElementDataTransformerChecker->check($builder, $this->collectionRepository, self::TYPE);
    }

    public function getBlockPrefix(): string
    {
        return 'sylius_cms_content_elements_' . self::TYPE;
    }
}
