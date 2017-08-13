<?php

namespace BitBag\CmsPlugin\Factory;

use BitBag\CmsPlugin\Entity\Block;
use BitBag\CmsPlugin\Entity\BlockInterface;

class BlockFactory implements BlockFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createWithType($type)
    {
        $block = new Block();

        $block
            ->setType($type);

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