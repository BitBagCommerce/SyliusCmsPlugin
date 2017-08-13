<?php

namespace BitBag\CmsPlugin\Form\Type;

use BitBag\CmsPlugin\Entity\BlockInterface;
use BitBag\CmsPlugin\Form\Type\Translation\ImageTranslationType;
use BitBag\CmsPlugin\Form\Type\Translation\TextTranslationType;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Bundle\ResourceBundle\Form\Type\ResourceTranslationsType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

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
            ->add('code', TextType::class)
        ;

        if ($block->getType() === BlockInterface::TEXT_BLOCK_TYPE) {
            $builder->add('translations', ResourceTranslationsType::class, [
                'entry_type' => TextTranslationType::class,
            ]);
        }

        if ($block->getType() === BlockInterface::IMAGE_BLOCK_TYPE) {
            $builder->add('translations', ResourceTranslationsType::class, [
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