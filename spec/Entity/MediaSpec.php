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

use BitBag\SyliusCmsPlugin\Entity\Media;
use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use BitBag\SyliusCmsPlugin\Entity\SectionInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use Symfony\Component\HttpFoundation\File\File;

final class MediaSpec extends ObjectBehavior
{
    function it_is_initializable(): void
    {
        $this->shouldHaveType(Media::class);
    }

    function it_is_a_resource(): void
    {
        $this->shouldHaveType(ResourceInterface::class);
    }

    function it_implements_media_interface(): void
    {
        $this->shouldHaveType(MediaInterface::class);
    }

    function it_allows_access_via_properties(): void
    {
        $this->setCode('file');
        $this->getCode()->shouldReturn('file');

        $this->setType('video');
        $this->getType()->shouldReturn('video');

        $this->setPath('/media/video');
        $this->getPath()->shouldReturn('/media/video');

        $file = new File(__DIR__ . '/MediaSpec.php');

        $this->setFile($file);
        $this->getFile()->shouldReturn($file);

        $this->setMimeType('video/mp4');
        $this->getMimeType()->shouldReturn('video/mp4');
    }

    function it_toggles(): void
    {
        $this->enable();
        $this->isEnabled()->shouldReturn(true);

        $this->disable();
        $this->isEnabled()->shouldReturn(false);
    }

    function it_associates_products(ProductInterface $firstProduct, ProductInterface $secondProduct): void
    {
        $this->addProduct($firstProduct);
        $this->hasProduct($firstProduct)->shouldReturn(true);

        $this->hasProduct($secondProduct)->shouldReturn(false);

        $this->removeProduct($firstProduct);

        $this->hasProduct($firstProduct)->shouldReturn(false);
    }

    function it_associates_sections(SectionInterface $firstSection, SectionInterface $secondSection): void
    {
        $this->addSection($firstSection);
        $this->hasSection($firstSection)->shouldReturn(true);

        $this->hasSection($secondSection)->shouldReturn(false);

        $this->removeSection($firstSection);

        $this->hasSection($firstSection)->shouldReturn(false);
    }

    function it_associates_channels(ChannelInterface $firstChannel, ChannelInterface $secondChannel): void
    {
        $this->addChannel($firstChannel);
        $this->hasChannel($firstChannel)->shouldReturn(true);

        $this->hasChannel($secondChannel)->shouldReturn(false);

        $this->removeChannel($firstChannel);

        $this->hasChannel($firstChannel)->shouldReturn(false);
    }
}
