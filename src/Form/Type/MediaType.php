<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Form\Type;

use BitBag\SyliusCmsPlugin\Form\Type\Translation\MediaTranslationType;
use Sylius\Bundle\ChannelBundle\Form\Type\ChannelChoiceType;
use Sylius\Bundle\ProductBundle\Form\Type\ProductAutocompleteChoiceType;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Bundle\ResourceBundle\Form\Type\ResourceTranslationsType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class MediaType extends AbstractResourceType
{
    /** @var array */
    private $providers;

    public function __construct(
        string $dataClass,
        array $validationGroups = [],
        array $providers = []
    ) {
        parent::__construct($dataClass, $validationGroups);

        $this->providers = $providers;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $data = $builder->getData();

        $builder
            ->add('code', TextType::class, [
                'label' => 'bitbag_sylius_cms_plugin.ui.code',
                'disabled' => null !== $data && null !== $data->getCode(),
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'bitbag_sylius_cms_plugin.ui.type',
                'choices' => $this->providers,
            ])
            ->add('file', FileType::class, [
                'label' => 'bitbag_sylius_cms_plugin.ui.file',
            ])
            ->add('sections', SectionAutocompleteChoiceType::class, [
                'label' => 'bitbag_sylius_cms_plugin.ui.sections',
                'multiple' => true,
            ])
            ->add('enabled', CheckboxType::class, [
                'label' => 'bitbag_sylius_cms_plugin.ui.enabled',
            ])
            ->add('saveWithOriginalName', CheckboxType::class, [
                'label' => 'bitbag_sylius_cms_plugin.ui.save_with_original_name',
            ])
            ->add('products', ProductAutocompleteChoiceType::class, [
                'label' => 'bitbag_sylius_cms_plugin.ui.products',
                'multiple' => true,
            ])
            ->add('channels', ChannelChoiceType::class, [
                'label' => 'bitbag_sylius_cms_plugin.ui.channels',
                'required' => false,
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('translations', ResourceTranslationsType::class, [
                'entry_type' => MediaTranslationType::class,
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'bitbag_sylius_cms_plugin_media';
    }
}
