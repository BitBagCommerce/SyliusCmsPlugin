<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Resolver;

use BitBag\SyliusCmsPlugin\Entity\BlockInterface;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
interface BlockTemplateResolverInterface
{
    const TEXT_BLOCK_TEMPLATE = '@BitBagSyliusCmsPlugin/Shop/Block/Show/textBlock.html.twig';
    const HTML_BLOCK_TEMPLATE = '@BitBagSyliusCmsPlugin/Shop/Block/Show/htmlBlock.html.twig';
    const IMAGE_BLOCK_TEMPLATE = '@BitBagSyliusCmsPlugin/Shop/Block/Show/imageBlock.html.twig';

    /**
     * @param BlockInterface $block
     *
     * @return string
     */
    public function resolveTemplate(BlockInterface $block): string;
}
