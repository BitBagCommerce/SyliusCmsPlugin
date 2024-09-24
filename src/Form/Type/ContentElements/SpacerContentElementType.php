<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Form\Type\ContentElements;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;

final class SpacerContentElementType extends AbstractType
{
    public const TYPE = 'spacer';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(self::TYPE, NumberType::class, [
                'label' => 'sylius_cms.ui.content_elements.type.' . self::TYPE . '_height',
                'attr' => [
                    'min' => 0,
                ],
                'html5' => true,
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'sylius_cms_content_elements_' . self::TYPE;
    }
}
