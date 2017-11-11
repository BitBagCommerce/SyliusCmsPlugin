<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

declare(strict_types=1);

namespace spec\BitBag\CmsPlugin\Entity;

use BitBag\CmsPlugin\Entity\Section;
use BitBag\CmsPlugin\Entity\SectionInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Resource\Model\ResourceInterface;

/**
 * @author Patryk Drapik <patryk.drapik@bitbag.pl>
 */
final class SectionSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(Section::class);
    }

    function it_is_a_resource(): void
    {
        $this->shouldHaveType(ResourceInterface::class);
    }

    function it_implements_section_interface(): void
    {
        $this->shouldHaveType(SectionInterface::class);
    }

    function it_allows_access_via_properties(): void
    {
        $this->setCode('blog');
        $this->getCode()->shouldReturn('blog');
    }
}