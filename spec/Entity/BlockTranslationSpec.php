<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Entity;

use BitBag\SyliusCmsPlugin\Entity\BlockTranslationInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TranslationInterface;

final class BlockTranslationSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(ResourceInterface::class);
    }

    function it_is_a_resource(): void
    {
        $this->shouldHaveType(ResourceInterface::class);
    }

    function it_implements_block_translation_interface(): void
    {
        $this->shouldHaveType(BlockTranslationInterface::class);
        $this->shouldHaveType(TranslationInterface::class);
    }

    function it_allows_access_via_properties(): void
    {
        $this->setName('Escobar favorite quote');
        $this->getName()->shouldReturn('Escobar favorite quote');

        $this->setLink('https://en.wikipedia.org/wiki/Pablo_Escobar');
        $this->getLink()->shouldReturn('https://en.wikipedia.org/wiki/Pablo_Escobar');

        $this->setContent('Plata o plomo');
        $this->getContent()->shouldReturn('Plata o plomo');
    }
}
