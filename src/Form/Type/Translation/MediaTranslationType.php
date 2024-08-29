<?php

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
                'label' => 'sylius_cms_plugin.ui.alt',
                'required' => false,
            ])
            ->add('link', TextType::class, [
                'label' => 'sylius_cms_plugin.ui.link',
                'required' => false,
            ])
            ->add('content', WysiwygType::class, [
                'label' => 'sylius_cms_plugin.ui.link_content',
                'required' => false,
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'sylius_cms_plugin_media_translation';
    }
}
