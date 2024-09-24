<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Form\Type;

use Sylius\Bundle\ChannelBundle\Form\Type\ChannelChoiceType;
use Sylius\Bundle\ProductBundle\Form\Type\ProductAutocompleteChoiceType;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Bundle\TaxonomyBundle\Form\Type\TaxonAutocompleteChoiceType;
use Sylius\CmsPlugin\Entity\BlockInterface;
use Sylius\Component\Locale\Model\LocaleInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class BlockType extends AbstractResourceType
{
    private array $locales = [];

    public function __construct(
        private RepositoryInterface $localeRepository,
        string $dataClass,
        array $validationGroups = [],
    ) {
        parent::__construct($dataClass, $validationGroups);

        /** @var LocaleInterface[] $locales */
        $locales = $this->localeRepository->findAll();
        foreach ($locales as $locale) {
            $this->locales[$locale->getName()] = $locale->getCode();
        }
    }

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
            ->add('contentElements', CollectionType::class, [
                'label' => false,
                'entry_type' => ContentConfigurationType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'required' => false,
                'entry_options' => [
                    'label' => false,
                ],
                'attr' => [
                    'class' => 'content-elements-container',
                ],
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
            ->add('locale', ChoiceType::class, [
                'choices' => $this->locales,
                'mapped' => false,
                'label' => 'sylius.ui.locale',
                'attr' => [
                    'class' => 'locale-selector',
                ],
            ])
        ;

        PageType::addContentElementLocaleListener($builder);
    }

    public function getBlockPrefix(): string
    {
        return 'sylius_cms_block';
    }
}
