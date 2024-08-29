<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Form\Type\Translation;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class PageTranslationType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('slug', TextType::class, [
                'label' => 'sylius_cms_plugin.ui.slug',
            ])
            ->add('title', TextType::class, [
                'label' => 'sylius_cms_plugin.ui.meta_title',
                'required' => false,
            ])
            ->add('metaKeywords', TextareaType::class, [
                'label' => 'sylius_cms_plugin.ui.meta_keywords',
                'required' => false,
            ])
            ->add('metaDescription', TextareaType::class, [
                'label' => 'sylius_cms_plugin.ui.meta_description',
                'required' => false,
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'sylius_cms_plugin_page_translation';
    }
}
