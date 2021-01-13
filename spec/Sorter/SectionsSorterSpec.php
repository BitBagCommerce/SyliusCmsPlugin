<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Sorter;

use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use BitBag\SyliusCmsPlugin\Entity\SectionInterface;
use BitBag\SyliusCmsPlugin\Sorter\SectionsSorter;
use BitBag\SyliusCmsPlugin\Sorter\SectionsSorterInterface;
use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;

final class SectionsSorterSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(SectionsSorter::class);
    }

    function it_implements_sections_sorter_interface(): void
    {
        $this->shouldHaveType(SectionsSorterInterface::class);
    }

    function it_sorts_sections(
        PageInterface $page,
        SectionInterface $section
    ): void {
        $section->getCode()->willReturn("SECTION_CODE");
        $page->getSections()->willReturn(new ArrayCollection([$section->getWrappedObject()]));

        $this->sortBySections([$page])->shouldReturn(
            [
                "SECTION_CODE" => ['section' => $section, 0 => $page]
            ]
        );
    }
}
