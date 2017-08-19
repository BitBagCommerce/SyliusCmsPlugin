<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace BitBag\CmsPlugin\Factory;

use BitBag\CmsPlugin\Entity\Block;

/**
 * @author Patryk Drapik <patryk.drapik@bitbag.pl>
 */
final class BlockFactory implements BlockFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createWithType($type)
    {
        $block = new Block();
        $block->setType($type);

        return $block;
    }

    /**
     * {@inheritdoc}
     */
    public function createNew()
    {
        return new Block();
    }
}