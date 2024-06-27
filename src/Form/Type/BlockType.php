<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Form\Type;

use BitBag\SyliusCmsPlugin\Entity\BlockInterface;
use Sylius\Bundle\ChannelBundle\Form\Type\ChannelChoiceType;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class BlockType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var BlockInterface $block */
        $block = $builder->getData();

        $builder
            ->add('code', TextType::class, [
                'label' => 'bitbag_sylius_cms_plugin.ui.code',
                'disabled' => null !== $block->getCode(),
            ])
            ->add('name', TextType::class, [
                'label' => 'bitbag_sylius_cms_plugin.ui.name',
            ])
            ->add('collections', CollectionAutocompleteChoiceType::class, [
                'label' => 'bitbag_sylius_cms_plugin.ui.collections',
                'multiple' => true,
            ])
            ->add('enabled', CheckboxType::class, [
                'label' => 'bitbag_sylius_cms_plugin.ui.enabled',
            ])
            ->add('channels', ChannelChoiceType::class, [
                'label' => 'bitbag_sylius_cms_plugin.ui.channels',
                'required' => false,
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('locales')
            ->add('contents', CollectionType::class, [
                'label' => false,
                'entry_type' => ContentConfigurationType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'required' => false,
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'bitbag_sylius_cms_plugin_block';
    }
}
