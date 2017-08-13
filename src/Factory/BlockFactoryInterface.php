<?php

namespace BitBag\CmsPlugin\Factory;

use BitBag\CmsPlugin\Entity\BlockInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

interface BlockFactoryInterface extends FactoryInterface
{
    /**
     * @param string $type
     *
     * @return BlockInterface
     */
    public function createWithType($type);
}