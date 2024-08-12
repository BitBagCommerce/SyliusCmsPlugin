<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Form\Type\ContentElements;

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
                'label' => 'bitbag_sylius_cms_plugin.ui.content_elements.type.' . self::TYPE . '_height',
                'attr' => [
                    "min" => 0,
                ],
                'html5' => true,
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'bitbag_sylius_cms_plugin_content_elements_' . self::TYPE;
    }
}
