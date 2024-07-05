<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Form\Type\ContentElements;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class HeadingContentElementType extends AbstractType
{
    public const TYPE = 'heading';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('heading_type', ChoiceType::class, [
                'label' => 'bitbag_sylius_cms_plugin.ui.content_elements.heading_type',
                'choices' => [
                    'bitbag_sylius_cms_plugin.ui.content_elements.heading_type.h1' => 'h1',
                    'bitbag_sylius_cms_plugin.ui.content_elements.heading_type.h2' => 'h2',
                    'bitbag_sylius_cms_plugin.ui.content_elements.heading_type.h3' => 'h3',
                    'bitbag_sylius_cms_plugin.ui.content_elements.heading_type.h4' => 'h4',
                    'bitbag_sylius_cms_plugin.ui.content_elements.heading_type.h5' => 'h5',
                    'bitbag_sylius_cms_plugin.ui.content_elements.heading_type.h6' => 'h6',
                ],
                'required' => true,
                'empty_data' => 'h1',
            ])
            ->add(self::TYPE, TextType::class, [
                'label' => 'bitbag_sylius_cms_plugin.ui.content_elements.type.'.self::TYPE,
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'bitbag_sylius_cms_plugin_content_elements_'.self::TYPE;
    }
}
