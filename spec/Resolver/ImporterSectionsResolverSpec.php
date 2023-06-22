<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Resolver;

use BitBag\SyliusCmsPlugin\Assigner\SectionsAssignerInterface;
use BitBag\SyliusCmsPlugin\Entity\SectionableInterface;
use BitBag\SyliusCmsPlugin\Resolver\ImporterSectionsResolver;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

final class ImporterSectionsResolverSpec extends ObjectBehavior
{
    public function let(SectionsAssignerInterface $sectionsAssigner)
    {
        $this->beConstructedWith($sectionsAssigner);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ImporterSectionsResolver::class);
    }

    public function it_resolves_sections_for_sectionable_entity(
        SectionsAssignerInterface $sectionsAssigner,
        SectionableInterface $sectionable
    ) {
        $sectionsRow = 'section1, section2, section3';
        $sectionCodes = ['section1', 'section2', 'section3'];

        $sectionsAssigner->assign($sectionable, $sectionCodes)->shouldBeCalled();

        $this->resolve($sectionable, $sectionsRow);
    }

    public function it_skips_resolution_when_sections_row_is_null(
        SectionsAssignerInterface $sectionsAssigner,
        SectionableInterface $sectionable
    ) {
        $sectionsRow = null;

        $sectionsAssigner->assign($sectionable, Argument::any())->shouldNotBeCalled();

        $this->resolve($sectionable, $sectionsRow);
    }
}
