<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace spec\BitBag\CmsPlugin\Entity;

use BitBag\CmsPlugin\Entity\BlockTranslation;
use BitBag\CmsPlugin\Entity\BlockTranslationInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\ImageInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
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
