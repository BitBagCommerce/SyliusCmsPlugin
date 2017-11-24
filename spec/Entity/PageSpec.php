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

use BitBag\SyliusCmsPlugin\Entity\Page;
use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use BitBag\SyliusCmsPlugin\Entity\SectionInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

final class PageSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(Page::class);
    }

    function it_is_a_resource(): void
    {
        $this->shouldHaveType(ResourceInterface::class);
    }

    function it_implements_page_interface(): void
    {
        $this->shouldHaveType(PageInterface::class);
    }

    function it_allows_access_via_properties(): void
    {
        $this->setCode('homepage');
        $this->getCode()->shouldReturn('homepage');
    }

    function it_toggles(): void
    {
        $this->enable();
        $this->isEnabled()->shouldReturn(true);

        $this->disable();
        $this->isEnabled()->shouldReturn(false);
    }

    function it_associates_products(ProductInterface $firstProduct, ProductInterface $secondProduct): void
    {
        $this->addProduct($firstProduct);
        $this->hasProduct($firstProduct)->shouldReturn(true);

        $this->hasProduct($secondProduct)->shouldReturn(false);

        $this->removeProduct($firstProduct);

        $this->hasProduct($firstProduct)->shouldReturn(false);
    }

    function it_associates_sections(SectionInterface $firstSection, SectionInterface $secondSection): void
    {
        $this->addSection($firstSection);
        $this->hasSection($firstSection)->shouldReturn(true);

        $this->hasSection($secondSection)->shouldReturn(false);

        $this->removeSection($firstSection);

        $this->hasSection($firstSection)->shouldReturn(false);
    }

    function it_is_timestampable(): void
    {
        $dateTime = new \DateTime();

        $this->setCreatedAt($dateTime);
        $this->getCreatedAt()->shouldReturn($dateTime);

        $this->setUpdatedAt($dateTime);
        $this->getUpdatedAt()->shouldReturn($dateTime);
    }
}
