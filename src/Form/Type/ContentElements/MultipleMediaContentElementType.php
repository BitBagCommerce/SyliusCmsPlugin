<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Form\Type\ContentElements;

use Sylius\CmsPlugin\Form\Type\MediaAutocompleteChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\FormBuilderInterface;

final class MultipleMediaContentElementType extends AbstractType
{
    public const TYPE = 'multiple_media';

    public function __construct(private DataTransformerInterface $mediaToCodesTransformer)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(self::TYPE, MediaAutocompleteChoiceType::class, [
                'label' => 'sylius_cms.ui.content_elements.type.' . self::TYPE,
                'multiple' => true,
            ])
        ;

        $builder->get(self::TYPE)->addModelTransformer($this->mediaToCodesTransformer);
    }

    public function getBlockPrefix(): string
    {
        return 'sylius_cms_content_elements_' . self::TYPE;
    }
}
