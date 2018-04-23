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

use BitBag\SyliusCmsPlugin\Entity\PageImageInterface;
use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use BitBag\SyliusCmsPlugin\Entity\PageTranslationInterface;
use BitBag\SyliusCmsPlugin\EventListener\PageImageUploadListener;
use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\Component\Core\Uploader\ImageUploaderInterface;

final class PageImageUploadListenerSpec extends ObjectBehavior
{
    public function let(ImageUploaderInterface $pageImageUploader): void
    {
        $this->beConstructedWith($pageImageUploader);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(PageImageUploadListener::class);
    }

    function it_does_not_upload_if_not_page_instance(
        ResourceControllerEvent $event,
        PageInterface $page
    ): void
    {
        $event->getSubject()->willReturn(Argument::any());

        $page->getTranslations()->shouldNotBeCalled();
    }

    function it_upload_image_for_each_translations(
        ResourceControllerEvent $event,
        PageInterface $page,
        PageTranslationInterface $pageTranslation,
        PageImageInterface $pageImage,
        ImageUploaderInterface $pageImageUploader
    ): void
    {
        $event->getSubject()->willReturn($page);
        $page->getTranslations()->willReturn(new ArrayCollection([$pageTranslation->getWrappedObject()]));
        $pageTranslation->getImage()->willReturn($pageImage);
        $pageImage->hasFile()->willReturn(true);

        $pageImageUploader->upload($pageImage)->shouldBeCalled();
        $this->uploadImage($event);
    }
}
