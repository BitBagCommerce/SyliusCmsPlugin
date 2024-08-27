<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Sylius\CmsPlugin\Form\Type\ContentElements;

use Sylius\CmsPlugin\Form\Type\WysiwygType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

final class TextareaContentElementType extends AbstractType
{
    public const TYPE = 'textarea';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(self::TYPE, WysiwygType::class, [
                'label' => 'sylius_cms_plugin.ui.content_elements.type.' . self::TYPE,
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'sylius_cms_plugin_content_elements_' . self::TYPE;
    }
}
