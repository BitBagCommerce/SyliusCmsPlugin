<?php

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
            $this->contentElements['sylius_cms_plugin.ui.content_elements.type.' . $type] = $type;
        }
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, [
                'label' => 'sylius_cms_plugin.ui.type',
                'choices' => $this->contentElements,
            ])
        ;
    }
}
