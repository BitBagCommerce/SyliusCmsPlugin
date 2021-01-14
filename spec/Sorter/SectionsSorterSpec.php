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

    function it_sorts_sections_with_one_element(
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

    function it_sorts_sections_with_more_elements(
        PageInterface $page1,
        PageInterface $page2,
        PageInterface $page3,
        SectionInterface $section1,
        SectionInterface $section2,
        SectionInterface $section3
    ): void {
        $section1->getCode()->willReturn("SECTION_1_CODE");
        $section2->getCode()->willReturn("SECTION_2_CODE");
        $section3->getCode()->willReturn("SECTION_3_CODE");

        $page1->getSections()->willReturn(new ArrayCollection(
            [$section1->getWrappedObject(), $section3->getWrappedObject()]
        ));
        $page2->getSections()->willReturn(new ArrayCollection([$section3->getWrappedObject()]));
        $page3->getSections()->willReturn(new ArrayCollection(
            [$section2->getWrappedObject(), $section1->getWrappedObject()]
        ));

        $this->sortBySections([$page1, $page2, $page3])->shouldReturn(
            [
                "SECTION_1_CODE" => ['section' => $section1, 0 => $page1, 1 => $page3],
                "SECTION_3_CODE" => ['section' => $section3, 0 => $page1, 1 => $page2],
                "SECTION_2_CODE" => ['section' => $section2, 0 => $page3],
            ]
        );
    }

    function it_sorts_sections_with_less_elements(
        PageInterface $page1,
        PageInterface $page2,
        SectionInterface $section1,
        SectionInterface $section2
    ): void {
        $section1->getCode()->willReturn("SECTION_1_CODE");
        $section2->getCode()->willReturn("SECTION_2_CODE");

        $page1->getSections()->willReturn(new ArrayCollection([$section1->getWrappedObject()]));
        $page2->getSections()->willReturn(new ArrayCollection([$section2->getWrappedObject()]));

        $this->sortBySections([$page1, $page2])->shouldReturn(
            [
                "SECTION_1_CODE" => ['section' => $section1, 0 => $page1],
                "SECTION_2_CODE" => ['section' => $section2, 0 => $page2],
            ]
        );
    }
}
