<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Entity;

use BitBag\SyliusCmsPlugin\Entity\MediaTranslation;
use BitBag\SyliusCmsPlugin\Entity\MediaTranslationInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TranslationInterface;

final class MediaTranslationSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(MediaTranslation::class);
    }

    public function it_is_a_resource(): void
    {
        $this->shouldHaveType(ResourceInterface::class);
    }

    public function it_implements_media_translation_interface(): void
    {
        $this->shouldHaveType(MediaTranslationInterface::class);
        $this->shouldHaveType(TranslationInterface::class);
    }

    public function it_allows_access_via_properties(): void
    {
        $this->setName('Video');
        $this->getName()->shouldReturn('Video');

        $this->setContent('Lorem ipsum');
        $this->getContent()->shouldReturn('Lorem ipsum');

        $this->setAlt('video');
        $this->getAlt()->shouldReturn('video');

        $this->setLink('https://github.com/Netimage/SyliusCmsPlugin');
        $this->getLink()->shouldReturn('https://github.com/Netimage/SyliusCmsPlugin');
    }
}
