<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

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
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $page = $builder->getData();

        $builder
            ->add('code', TextType::class, [
                'label' => 'bitbag.cms.form.code',
                'disabled' => null !== $page->getCode(),
            ])
            ->add('enabled', CheckboxType::class, [
                'label' => 'bitbag.cms.enabled',
            ])
            ->add('products', ProductAutocompleteChoiceType::class, [
                'label' => 'bitbag.cms.products',
                'multiple' => true,
            ])
            ->add('translations', ResourceTranslationsType::class, [
                'label' => 'bitbag.cms.form.images',
                'entry_type' => PageTranslationType::class,
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'bitbag_cms_plugin_page';
    }
}