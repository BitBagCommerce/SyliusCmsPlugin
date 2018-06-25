<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Factory;

use BitBag\SyliusCmsPlugin\Entity\BlockInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

interface BlockFactoryInterface extends FactoryInterface
{
    public function createWithType(string $type): BlockInterface;
}
