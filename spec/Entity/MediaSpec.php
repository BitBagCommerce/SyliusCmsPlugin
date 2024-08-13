<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Entity;

use BitBag\SyliusCmsPlugin\Entity\CollectionInterface;
use BitBag\SyliusCmsPlugin\Entity\Media;
use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class MediaSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Media::class);
    }

    public function it_is_a_resource(): void
    {
        $this->shouldHaveType(ResourceInterface::class);
    }

    public function it_implements_media_interface(): void
    {
        $this->shouldHaveType(MediaInterface::class);
    }

    public function it_allows_access_via_properties(): void
    {
        $this->setCode('file');
        $this->getCode()->shouldReturn('file');

        $this->setName('Video');
        $this->getName()->shouldReturn('Video');

        $this->setType('video');
        $this->getType()->shouldReturn('video');

        $this->setPath('/media/video');
        $this->getPath()->shouldReturn('/media/video');

        $file = new UploadedFile(__DIR__ . '/MediaSpec.php', 'originalName');

        $this->setFile($file);
        $this->getFile()->shouldReturn($file);

        $this->setMimeType('video/mp4');
        $this->getMimeType()->shouldReturn('video/mp4');
    }

    public function it_toggles(): void
    {
        $this->enable();
        $this->isEnabled()->shouldReturn(true);

        $this->disable();
        $this->isEnabled()->shouldReturn(false);
    }

    public function it_associates_collections(CollectionInterface $firstCollection, CollectionInterface $secondCollection): void
    {
        $this->addCollection($firstCollection);
        $this->hasCollection($firstCollection)->shouldReturn(true);

        $this->hasCollection($secondCollection)->shouldReturn(false);

        $this->removeCollection($firstCollection);

        $this->hasCollection($firstCollection)->shouldReturn(false);
    }

    public function it_associates_channels(ChannelInterface $firstChannel, ChannelInterface $secondChannel): void
    {
        $this->addChannel($firstChannel);
        $this->hasChannel($firstChannel)->shouldReturn(true);

        $this->hasChannel($secondChannel)->shouldReturn(false);

        $this->removeChannel($firstChannel);

        $this->hasChannel($firstChannel)->shouldReturn(false);
    }
}
