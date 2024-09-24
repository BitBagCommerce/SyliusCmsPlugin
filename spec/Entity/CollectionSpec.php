<?php

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Entity;

use PhpSpec\ObjectBehavior;
use Sylius\CmsPlugin\Entity\Collection;
use Sylius\CmsPlugin\Entity\CollectionInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

final class CollectionSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Collection::class);
    }

    public function it_is_a_resource(): void
    {
        $this->shouldHaveType(ResourceInterface::class);
    }

    public function it_implements_collection_interface(): void
    {
        $this->shouldHaveType(CollectionInterface::class);
    }

    public function it_allows_access_via_properties(): void
    {
        $this->setCode('blog');
        $this->getCode()->shouldReturn('blog');
    }
}
