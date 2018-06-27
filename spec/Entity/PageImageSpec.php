<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Entity;

use BitBag\SyliusCmsPlugin\Entity\PageImage;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\Image as SyliusImage;

final class PageImageSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(PageImage::class);
    }

    function it_extends_sylius_image(): void
    {
        $this->shouldHaveType(SyliusImage::class);
    }
}
