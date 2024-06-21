<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Form\Type\BlockContent;

use BitBag\SyliusCmsPlugin\Form\Type\WysiwygType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class BlockContentTextConfigurationType extends AbstractType
{
    public const TYPE = 'content_text';

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'label' => 'bitbag_sylius_cms_plugin.ui.text',
        ]);
    }

    public function getParent(): string
    {
        return WysiwygType::class;
    }
}
