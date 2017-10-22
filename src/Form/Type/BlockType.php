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

use BitBag\CmsPlugin\Entity\BlockInterface;
use BitBag\CmsPlugin\Form\Type\Translation\HtmlBlockTranslationType;
use BitBag\CmsPlugin\Form\Type\Translation\ImageBlockTranslationType;
use BitBag\CmsPlugin\Form\Type\Translation\TextBlockTranslationType;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Bundle\ResourceBundle\Form\Type\ResourceTranslationsType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @author Patryk Drapik <patryk.drapik@bitbag.pl>
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class BlockType extends AbstractResourceType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var BlockInterface $block */
        $block = $builder->getData();

        $builder
            ->add('code', TextType::class, [
                'label' => 'bitbag.ui.code',
                'disabled' => null !== $block->getCode(),
            ])
            ->add('enabled', CheckboxType::class, [
                'label' => 'bitbag.ui.enabled',
            ])
        ;

        $this->resolveBlockType($block, $builder);
    }

    /**
     * @param FormBuilderInterface $builder
     * @param BlockInterface $block
     */
    private function resolveBlockType(BlockInterface $block, FormBuilderInterface $builder): void
    {
        if (BlockInterface::TEXT_BLOCK_TYPE === $block->getType()) {
            $builder->add('translations', ResourceTranslationsType::class, [
                'label' => 'bitbag.ui.contents',
                'entry_type' => TextBlockTranslationType::class,
            ]);

            return;
        }

        if (BlockInterface::HTML_BLOCK_TYPE === $block->getType()) {
            $builder->add('translations', ResourceTranslationsType::class, [
                'label' => 'bitbag.ui.contents',
                'entry_type' => HtmlBlockTranslationType::class,
            ]);

            return;
        }

        if (BlockInterface::IMAGE_BLOCK_TYPE === $block->getType()) {
            $builder->add('translations', ResourceTranslationsType::class, [
                'label' => 'bitbag.ui.images',
                'entry_type' => ImageBlockTranslationType::class,
            ]);

            return;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'bitbag_plugin_block';
    }
}
