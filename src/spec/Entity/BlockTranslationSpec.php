<?php

namespace spec\BitBag\CmsPlugin\Entity;

use BitBag\CmsPlugin\Entity\BlockTranslation;
use BitBag\CmsPlugin\Entity\BlockTranslationInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Core\Model\ImageInterface;

final class BlockTranslationSpec extends ObjectBehavior
{
    const CONTENT = 'Lorem Ipsum';

    function it_is_initializable()
    {
        $this->shouldHaveType(BlockTranslation::class);
        $this->shouldHaveType(BlockTranslationInterface::class);
        $this->shouldHaveType(ResourceInterface::class);
    }

    function it_allows_access_via_properties(ImageInterface $image)
    {
        $this->setContent(self::CONTENT);
        $this->getContent()->shouldReturn('Lorem Ipsum');
        $this->setImage($image);
        $this->getImage()->shouldReturnAnInstanceOf('Double\ImageInterface\P1');
    }
}
