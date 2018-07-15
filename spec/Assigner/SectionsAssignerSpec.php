<?php

namespace spec\BitBag\SyliusCmsPlugin\Assigner;

use BitBag\SyliusCmsPlugin\Assigner\SectionsAssigner;
use BitBag\SyliusCmsPlugin\Assigner\SectionsAssignerInterface;
use BitBag\SyliusCmsPlugin\Entity\SectionInterface;
use BitBag\SyliusCmsPlugin\Repository\SectionRepositoryInterface;
use PhpSpec\ObjectBehavior;
use BitBag\SyliusCmsPlugin\Entity\SectionableInterface;

final class SectionsAssignerSpec extends ObjectBehavior
{
    function let(SectionRepositoryInterface $sectionRepository): void
    {
        $this->beConstructedWith($sectionRepository);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(SectionsAssigner::class);
    }

    function it_implements_sections_assigner_interface(): void
    {
        $this->shouldHaveType(SectionsAssignerInterface::class);
    }

    function it_assigns_sections(
        SectionRepositoryInterface $sectionRepository,
        SectionInterface $aboutSection,
        SectionInterface $blogSection,
        SectionableInterface $sectionsAware
    ): void
    {
        $sectionRepository->findOneBy(['code' => 'about'])->willReturn($aboutSection);
        $sectionRepository->findOneBy(['code' => 'blog'])->willReturn($blogSection);

        $sectionsAware->addSection($aboutSection)->shouldBeCalled();
        $sectionsAware->addSection($blogSection)->shouldBeCalled();

        $this->assign($sectionsAware, ['about', 'blog']);
    }
}
