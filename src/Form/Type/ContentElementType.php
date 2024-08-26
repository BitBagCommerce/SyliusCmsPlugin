<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Sylius\CmsPlugin\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

final class ContentElementType extends AbstractType
{
    private array $contentElements = [];

    public function __construct(
        private iterable $contentElementTypes,
    ) {
        foreach ($this->contentElementTypes as $type => $formType) {
            $this->contentElements['bitbag_sylius_cms_plugin.ui.content_elements.type.' . $type] = $type;
        }
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, [
                'label' => 'bitbag_sylius_cms_plugin.ui.type',
                'choices' => $this->contentElements,
            ])
        ;
    }
}
