<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\CmsPlugin\Factory;

use BitBag\CmsPlugin\Entity\BlockInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

/**
 * @author Patryk Drapik <patryk.drapik@bitbag.pl>
 */
interface BlockFactoryInterface extends FactoryInterface
{
    /**
     * @param string $type
     *
     * @return BlockInterface
     */
    public function createWithType(string $type): BlockInterface;
}
