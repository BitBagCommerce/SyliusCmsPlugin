<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Form\Type;

use Sylius\Bundle\ChannelBundle\Form\Type\ChannelChoiceType;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Bundle\ResourceBundle\Form\Type\ResourceTranslationsType;
use Sylius\CmsPlugin\Form\Type\Translation\PageTranslationType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class PageType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', TextType::class, [
                'label' => 'sylius_cms.ui.code',
                'disabled' => null !== $builder->getData()->getCode(),
            ])
            ->add('name', TextType::class, [
                'label' => 'sylius_cms.ui.name',
            ])
            ->add('enabled', CheckboxType::class, [
                'label' => 'sylius_cms.ui.enabled',
            ])
            ->add('translations', ResourceTranslationsType::class, [
                'label' => 'sylius_cms.ui.images',
                'entry_type' => PageTranslationType::class,
            ])
            ->add('collections', CollectionAutocompleteChoiceType::class, [
                'label' => 'sylius_cms.ui.collections',
                'multiple' => true,
            ])
            ->add('channels', ChannelChoiceType::class, [
                'label' => 'sylius_cms.ui.channels',
                'required' => false,
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('publishAt', DateTimeType::class, [
                'input' => 'datetime_immutable',
                'label' => 'sylius_cms.ui.publish_at',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'required' => false,
            ])
            ->add('contentElements', CollectionType::class, [
                'label' => false,
                'entry_type' => ContentConfigurationType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'required' => false,
            ])
            ->add('template', TemplatePageAutocompleteChoiceType::class, [
                'label' => false,
                'mapped' => false,
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'sylius_cms_page';
    }
}
