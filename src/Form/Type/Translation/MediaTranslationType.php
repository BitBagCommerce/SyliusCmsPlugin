<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Sylius\CmsPlugin\Form\Type\Translation;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\CmsPlugin\Form\Type\WysiwygType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class MediaTranslationType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('alt', TextType::class, [
                'label' => 'bitbag_sylius_cms_plugin.ui.alt',
                'required' => false,
            ])
            ->add('link', TextType::class, [
                'label' => 'bitbag_sylius_cms_plugin.ui.link',
                'required' => false,
            ])
            ->add('content', WysiwygType::class, [
                'label' => 'bitbag_sylius_cms_plugin.ui.link_content',
                'required' => false,
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'bitbag_sylius_cms_plugin_media_translation';
    }
}
