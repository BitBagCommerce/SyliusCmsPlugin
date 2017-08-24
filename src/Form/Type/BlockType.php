<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace BitBag\CmsPlugin\Form\Type;

use BitBag\CmsPlugin\Entity\BlockInterface;
use BitBag\CmsPlugin\Form\Type\Translation\ImageTranslationType;
use BitBag\CmsPlugin\Form\Type\Translation\TextTranslationType;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Bundle\ResourceBundle\Form\Type\ResourceTranslationsType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @author Patryk Drapik <patryk.drapik@bitbag.pl>
 */
final class BlockType extends AbstractResourceType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var BlockInterface $block */
        $block = $builder->getData();

        $builder
            ->add('code', TextType::class, [
                'label' => 'bitbag.form.code',
                'disabled' => $block->getCode() !== null,
            ])
            ->add('enabled', CheckboxType::class, [
                'label' => 'bitbag.form.enabled',
            ])
        ;

        if (BlockInterface::TEXT_BLOCK_TYPE === $block->getType()) {
            $builder->add('translations', ResourceTranslationsType::class, [
                'label' => 'bitbag.form.contents',
                'entry_type' => TextTranslationType::class,
            ]);
        }

        if (BlockInterface::IMAGE_BLOCK_TYPE === $block->getType()) {
            $builder->add('translations', ResourceTranslationsType::class, [
                'label' => 'bitbag.form.images',
                'entry_type' => ImageTranslationType::class,
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'bitbag_cms_plugin_block';
    }
}