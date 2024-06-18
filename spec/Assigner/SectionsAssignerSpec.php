<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Assigner;

use BitBag\SyliusCmsPlugin\Assigner\CollectionsAssigner;
use BitBag\SyliusCmsPlugin\Assigner\CollectionsAssignerInterface;
use BitBag\SyliusCmsPlugin\Entity\CollectionableInterface;
use BitBag\SyliusCmsPlugin\Entity\CollectionInterface;
use BitBag\SyliusCmsPlugin\Repository\CollectionRepositoryInterface;
use PhpSpec\ObjectBehavior;

final class SectionsAssignerSpec extends ObjectBehavior
{
    public function let(CollectionRepositoryInterface $sectionRepository): void
    {
        $this->beConstructedWith($sectionRepository);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(CollectionsAssigner::class);
    }

    public function it_implements_sections_assigner_interface(): void
    {
        $this->shouldHaveType(CollectionsAssignerInterface::class);
    }

    public function it_assigns_sections(
        CollectionRepositoryInterface $sectionRepository,
        CollectionInterface           $aboutSection,
        CollectionInterface           $blogSection,
        CollectionableInterface       $sectionsAware
    ): void {
        $sectionRepository->findOneBy(['code' => 'about'])->willReturn($aboutSection);
        $sectionRepository->findOneBy(['code' => 'blog'])->willReturn($blogSection);

        $sectionsAware->addCollection($aboutSection)->shouldBeCalled();
        $sectionsAware->addCollection($blogSection)->shouldBeCalled();

        $this->assign($sectionsAware, ['about', 'blog']);
    }
}
