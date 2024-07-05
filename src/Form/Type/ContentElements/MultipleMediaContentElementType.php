<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/


declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Form\Type\ContentElements;

use BitBag\SyliusCmsPlugin\Form\Type\MediaAutocompleteChoiceType;
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
                'label' => 'bitbag_sylius_cms_plugin.ui.content_elements.type.'.self::TYPE,
                'multiple' => true,
            ])
        ;

        $builder->get(self::TYPE)->addModelTransformer($this->mediaToCodesTransformer);
    }

    public function getBlockPrefix(): string
    {
        return 'bitbag_sylius_cms_plugin_content_elements_'.self::TYPE;
    }
}
