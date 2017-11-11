<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\CmsPlugin\Entity;

use Sylius\Component\Core\Model\Image as BaseImage;
use Sylius\Component\Core\Model\ImageInterface;

/**
 * @author Patryk Drapik <patryk.drapik@bitbag.pl>
 */
class BlockImage extends BaseImage implements ImageInterface
{
}
