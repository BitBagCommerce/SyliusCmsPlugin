<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Form\Type\ContentElements;

use BitBag\SyliusCmsPlugin\Form\DataTransformer\ContentElementDataTransformerChecker;
use BitBag\SyliusCmsPlugin\Form\Type\MediaAutocompleteChoiceType;
use Sylius\Bundle\ResourceBundle\Form\DataTransformer\ResourceToIdentifierTransformer;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
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
            ->add(self::TYPE, MediaAutocompleteChoiceType::class, [
                'label' => 'bitbag_sylius_cms_plugin.ui.content_elements.type.' . self::TYPE,
            ])
        ;

        $builder->get(self::TYPE)->addModelTransformer(
            new ReversedTransformer(new ResourceToIdentifierTransformer($this->mediaRepository, 'code')),
        );

        $this->contentElementDataTransformerChecker->check($builder, $this->mediaRepository, self::TYPE);
    }

    public function getBlockPrefix(): string
    {
        return 'bitbag_sylius_cms_plugin_content_elements_' . self::TYPE;
    }
}
