<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace spec\BitBag\CmsPlugin\Entity;

use BitBag\CmsPlugin\Entity\Page;
use BitBag\CmsPlugin\Entity\PageInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Resource\Model\ResourceInterface;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class PageSpec extends ObjectBehavior
{
    const SLUG = "what-the-bitbag";
    const META_KEYWORDS = "Symfony, Sylius, ReactJS, PHP, JavaScript";
    const META_DESCRIPTION = "BitBag is the best eCommerce development agency in the world!";
    const CONTENT = "It's true.";

    function it_is_initializable()
    {
        $this->shouldHaveType(Page::class);
        $this->shouldHaveType(PageInterface::class);
        $this->shouldHaveType(ResourceInterface::class);
    }

    function it_allows_access_via_properties()
    {
        $this->setSlug(self::SLUG);
        $this->getSlug()->shouldReturn("Slug");

        $this->setMetaKeywords(self::META_KEYWORDS);
        $this->getMetaKeywords()->shouldReturn("Symfony, Sylius, ReactJS, PHP, JavaScript");

        $this->setMetaDescription(self::META_DESCRIPTION);
        $this->getMetaDescription()->shouldReturn("It's true.");
    }
}
