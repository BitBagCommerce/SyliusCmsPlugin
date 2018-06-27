<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\EventListener;

use BitBag\SyliusCmsPlugin\Entity\BlockImageInterface;
use BitBag\SyliusCmsPlugin\Entity\BlockInterface;
use BitBag\SyliusCmsPlugin\Entity\BlockTranslationInterface;
use BitBag\SyliusCmsPlugin\EventListener\BlockImageUploadListener;
use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\Component\Core\Uploader\ImageUploaderInterface;

final class BlockImageUploadListenerSpec extends ObjectBehavior
{
    public function let(ImageUploaderInterface $blockImageUploader): void
    {
        $this->beConstructedWith($blockImageUploader);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(BlockImageUploadListener::class);
    }

    function it_does_not_upload_if_not_block_instance(
        ResourceControllerEvent $event,
        BlockInterface $block
    ): void {
        $event->getSubject()->willReturn(Argument::any());

        $block->getType()->shouldNotBeCalled();
    }

    function it_does_not_upload_if_not_image_Block(
        ResourceControllerEvent $event,
        BlockInterface $block
    ): void {
        $event->getSubject()->willReturn($block);
        $block->getType()->willReturn(Argument::any());

        $block->getTranslations()->shouldNotBeCalled();
    }

    function it_upload_image_for_each_translations(
        ResourceControllerEvent $event,
        BlockInterface $block,
        BlockTranslationInterface $blockTranslation,
        BlockImageInterface $blockImage,
        ImageUploaderInterface $blockImageUploader
    ): void {
        $event->getSubject()->willReturn($block);
        $block->getType()->willReturn('image');
        $block->getTranslations()->willReturn(new ArrayCollection([$blockTranslation->getWrappedObject()]));
        $blockTranslation->getImage()->willReturn($blockImage);
        $blockImage->hasFile()->willReturn(true);

        $blockImageUploader->upload($blockImage)->shouldBeCalled();
        $this->uploadImage($event);
    }
}
