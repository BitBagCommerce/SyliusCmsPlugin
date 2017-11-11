<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\CmsPlugin\Form\Type;

use BitBag\CmsPlugin\Form\Type\Translation\PageTranslationType;
use Sylius\Bundle\ProductBundle\Form\Type\ProductAutocompleteChoiceType;
use Sylius\Bundle\ResourceBundle\Form\Type\ResourceTranslationsType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;

/**
 * @author Patryk Drapik <patryk.drapik@bitbag.pl>
 */
final class PageType extends AbstractResourceType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $page = $builder->getData();

        $builder
            ->add('code', TextType::class, [
                'label' => 'bitbag.ui.code',
                'disabled' => null !== $page->getCode(),
            ])
            ->add('enabled', CheckboxType::class, [
                'label' => 'bitbag.ui.enabled',
            ])
            ->add('products', ProductAutocompleteChoiceType::class, [
                'label' => 'bitbag.ui.products',
                'multiple' => true,
            ])
            ->add('translations', ResourceTranslationsType::class, [
                'label' => 'bitbag.ui.images',
                'entry_type' => PageTranslationType::class,
            ])
            ->add('sections', SectionAutocompleteChoiceType::class, [
                'label' => 'bitbag.ui.sections',
                'multiple' => true,
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'bitbag_plugin_page';
    }
}
