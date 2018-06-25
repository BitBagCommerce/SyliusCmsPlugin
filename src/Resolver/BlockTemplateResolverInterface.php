<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Resolver;

use BitBag\SyliusCmsPlugin\Entity\BlockInterface;

interface BlockTemplateResolverInterface
{
    const TEXT_BLOCK_TEMPLATE = '@BitBagSyliusCmsPlugin/Shop/Block/Show/textBlock.html.twig';
    const HTML_BLOCK_TEMPLATE = '@BitBagSyliusCmsPlugin/Shop/Block/Show/htmlBlock.html.twig';
    const IMAGE_BLOCK_TEMPLATE = '@BitBagSyliusCmsPlugin/Shop/Block/Show/imageBlock.html.twig';

    public function resolveTemplate(BlockInterface $block): string;
}
