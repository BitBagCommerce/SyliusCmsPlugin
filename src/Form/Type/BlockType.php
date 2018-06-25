<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Form\Type;

use BitBag\SyliusCmsPlugin\Entity\BlockInterface;
use BitBag\SyliusCmsPlugin\Form\Type\Translation\HtmlBlockTranslationType;
use BitBag\SyliusCmsPlugin\Form\Type\Translation\ImageBlockTranslationType;
use BitBag\SyliusCmsPlugin\Form\Type\Translation\TextBlockTranslationType;
use Sylius\Bundle\ChannelBundle\Form\Type\ChannelChoiceType;
use Sylius\Bundle\ProductBundle\Form\Type\ProductAutocompleteChoiceType;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Bundle\ResourceBundle\Form\Type\ResourceTranslationsType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Valid;

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
            ->add('sections', SectionAutocompleteChoiceType::class, [
                'label' => 'bitbag_sylius_cms_plugin.ui.sections',
                'multiple' => true,
            ])
            ->add('enabled', CheckboxType::class, [
                'label' => 'bitbag_sylius_cms_plugin.ui.enabled',
            ])
            ->add('products', ProductAutocompleteChoiceType::class, [
                'label' => 'bitbag_sylius_cms_plugin.ui.products',
                'multiple' => true,
            ])
            ->add('channels', ChannelChoiceType::class, [
                'multiple' => true,
                'expanded' => true,
                'label' => 'bitbag_sylius_cms_plugin.ui.channels',
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
                'label' => 'bitbag_sylius_cms_plugin.ui.contents',
                'entry_type' => TextBlockTranslationType::class,
                'validation_groups' => ['bitbag_content'],
                'constraints' => [
                    new Valid(),
                ],
            ]);

            return;
        }

        if (BlockInterface::HTML_BLOCK_TYPE === $block->getType()) {
            $builder->add('translations', ResourceTranslationsType::class, [
                'label' => 'bitbag_sylius_cms_plugin.ui.contents',
                'entry_type' => HtmlBlockTranslationType::class,
                'validation_groups' => ['bitbag_content'],
                'constraints' => [
                    new Valid(),
                ],
            ]);

            return;
        }

        if (BlockInterface::IMAGE_BLOCK_TYPE === $block->getType()) {
            $builder->add('translations', ResourceTranslationsType::class, [
                'label' => 'bitbag_sylius_cms_plugin.ui.images',
                'entry_type' => ImageBlockTranslationType::class,
                'validation_groups' => null === $block->getId() ? ['bitbag_image'] : [],
                'constraints' => [
                    new Valid(),
                ],
            ]);

            return;
        }
    }

    public function getBlockPrefix(): string
    {
        return 'bitbag_sylius_cms_plugin_block';
    }
}
