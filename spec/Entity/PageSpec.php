<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Entity;

use BitBag\SyliusCmsPlugin\Entity\CollectionInterface;
use BitBag\SyliusCmsPlugin\Entity\Page;
use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

final class PageSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Page::class);
    }

    public function it_is_a_resource(): void
    {
        $this->shouldHaveType(ResourceInterface::class);
    }

    public function it_implements_page_interface(): void
    {
        $this->shouldHaveType(PageInterface::class);
    }

    public function it_allows_access_via_properties(): void
    {
        $this->setCode('homepage');
        $this->getCode()->shouldReturn('homepage');
    }

    public function it_toggles(): void
    {
        $this->enable();
        $this->isEnabled()->shouldReturn(true);

        $this->disable();
        $this->isEnabled()->shouldReturn(false);
    }

    public function it_associates_collections(CollectionInterface $firstCollection, CollectionInterface $secondCollection): void
    {
        $this->addCollection($firstCollection);
        $this->hasCollection($firstCollection)->shouldReturn(true);

        $this->hasCollection($secondCollection)->shouldReturn(false);

        $this->removeCollection($firstCollection);

        $this->hasCollection($firstCollection)->shouldReturn(false);
    }

    public function it_associates_channels(ChannelInterface $firstChannel, ChannelInterface $secondChannel): void
    {
        $this->addChannel($firstChannel);
        $this->hasChannel($firstChannel)->shouldReturn(true);

        $this->hasChannel($secondChannel)->shouldReturn(false);

        $this->removeChannel($firstChannel);

        $this->hasChannel($firstChannel)->shouldReturn(false);
    }

    public function it_is_timestampable(): void
    {
        $dateTime = new \DateTime();

        $this->setCreatedAt($dateTime);
        $this->getCreatedAt()->shouldReturn($dateTime);

        $this->setUpdatedAt($dateTime);
        $this->getUpdatedAt()->shouldReturn($dateTime);
    }
}
