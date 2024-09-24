<?php

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Entity;

use PhpSpec\ObjectBehavior;
use Sylius\CmsPlugin\Entity\MediaTranslation;
use Sylius\CmsPlugin\Entity\MediaTranslationInterface;
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
        $this->setContent('Lorem ipsum');
        $this->getContent()->shouldReturn('Lorem ipsum');

        $this->setAlt('video');
        $this->getAlt()->shouldReturn('video');

        $this->setLink('https://github.com/Netimage/SyliusCmsPlugin');
        $this->getLink()->shouldReturn('https://github.com/Netimage/SyliusCmsPlugin');
    }
}
