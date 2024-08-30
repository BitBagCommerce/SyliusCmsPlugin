<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Form\Type;

use Sylius\Bundle\ChannelBundle\Form\Type\ChannelChoiceType;
use Sylius\Bundle\ProductBundle\Form\Type\ProductAutocompleteChoiceType;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Bundle\TaxonomyBundle\Form\Type\TaxonAutocompleteChoiceType;
use Sylius\CmsPlugin\Entity\BlockInterface;
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
                'label' => 'sylius_cms.ui.code',
                'disabled' => null !== $block->getCode(),
            ])
            ->add('name', TextType::class, [
                'label' => 'sylius_cms.ui.name',
            ])
            ->add('collections', CollectionAutocompleteChoiceType::class, [
                'label' => 'sylius_cms.ui.collections',
                'multiple' => true,
            ])
            ->add('enabled', CheckboxType::class, [
                'label' => 'sylius_cms.ui.enabled',
            ])
            ->add('channels', ChannelChoiceType::class, [
                'label' => 'sylius_cms.ui.channels',
                'required' => false,
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('locales')
            ->add('contentElements', CollectionType::class, [
                'label' => false,
                'entry_type' => ContentConfigurationType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'required' => false,
            ])
            ->add('products', ProductAutocompleteChoiceType::class, [
                'label' => 'sylius_cms.ui.display_for_products.label',
                'multiple' => true,
                'help' => 'sylius_cms.ui.display_for_products.help',
            ])
            ->add('productsInTaxons', TaxonAutocompleteChoiceType::class, [
                'label' => 'sylius_cms.ui.display_for_products_in_taxons.label',
                'multiple' => true,
                'help' => 'sylius_cms.ui.display_for_products_in_taxons.help',
            ])
            ->add('taxons', TaxonAutocompleteChoiceType::class, [
                'label' => 'sylius_cms.ui.display_for_taxons.label',
                'multiple' => true,
                'help' => 'sylius_cms.ui.display_for_taxons.help',
            ])
            ->add('template', TemplateBlockAutocompleteChoiceType::class, [
                'label' => false,
                'mapped' => false,
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'sylius_cms_block';
    }
}
