<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Form\Type\ContentElements;

use Sylius\Bundle\ResourceBundle\Form\DataTransformer\ResourceToIdentifierTransformer;
use Sylius\CmsPlugin\Form\DataTransformer\ContentElementDataTransformerChecker;
use Sylius\CmsPlugin\Form\Type\Autocomplete\MediaAutocompleteType;
use Sylius\CmsPlugin\Form\Type\MediaAutocompleteChoiceType;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\ReversedTransformer;

final class SingleMediaContentElementType extends AbstractType
{
    public const TYPE = 'single_media';

    public function __construct(
        private RepositoryInterface $mediaRepository,
        private ContentElementDataTransformerChecker $contentElementDataTransformerChecker,
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(self::TYPE, MediaAutocompleteType::class, [
                'label' => 'sylius_cms.ui.content_elements.type.' . self::TYPE,
            ])
        ;

        $builder->get(self::TYPE)->addModelTransformer(
            new ReversedTransformer(new ResourceToIdentifierTransformer($this->mediaRepository, 'code')),
        );

        $this->contentElementDataTransformerChecker->check($builder, $this->mediaRepository, self::TYPE);
    }

    public function getBlockPrefix(): string
    {
        return 'sylius_cms_content_elements_' . self::TYPE;
    }
}
