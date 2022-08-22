<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Entity;

use BitBag\SyliusCmsPlugin\Entity\BlockTranslationInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TranslationInterface;

final class BlockTranslationSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(ResourceInterface::class);
    }

    public function it_is_a_resource(): void
    {
        $this->shouldHaveType(ResourceInterface::class);
    }

    public function it_implements_block_translation_interface(): void
    {
        $this->shouldHaveType(BlockTranslationInterface::class);
        $this->shouldHaveType(TranslationInterface::class);
    }

    public function it_allows_access_via_properties(): void
    {
        $this->setName('Escobar favorite quote');
        $this->getName()->shouldReturn('Escobar favorite quote');

        $this->setLink('https://en.wikipedia.org/wiki/Pablo_Escobar');
        $this->getLink()->shouldReturn('https://en.wikipedia.org/wiki/Pablo_Escobar');

        $this->setContent('Plata o plomo');
        $this->getContent()->shouldReturn('Plata o plomo');
    }
}
