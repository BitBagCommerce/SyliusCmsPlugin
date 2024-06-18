<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Entity;

use BitBag\SyliusCmsPlugin\Entity\CollectionTranslation;
use BitBag\SyliusCmsPlugin\Entity\CollectionTranslationInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TranslationInterface;

final class SectionTranslationSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(CollectionTranslation::class);
    }

    public function it_is_a_resource()
    {
        $this->shouldHaveType(ResourceInterface::class);
    }

    public function it_implements_frequently_asked_question_translation_interface()
    {
        $this->shouldHaveType(CollectionTranslationInterface::class);
        $this->shouldHaveType(TranslationInterface::class);
    }

    public function it_allows_access_via_properties()
    {
        $this->setName('Blog');
        $this->getName()->shouldReturn('Blog');
    }
}
