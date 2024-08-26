<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\MediaProvider;

use PhpSpec\ObjectBehavior;
use Sylius\CmsPlugin\Entity\MediaInterface;
use Sylius\CmsPlugin\MediaProvider\GenericProvider;
use Sylius\CmsPlugin\MediaProvider\ProviderInterface;
use Sylius\CmsPlugin\Uploader\MediaUploaderInterface;
use Twig\Environment;

final class GenericProviderSpec extends ObjectBehavior
{
    public function let(
        MediaUploaderInterface $uploader,
        Environment $twigEngine,
    ) {
        $this->beConstructedWith($uploader, $twigEngine, '@Template', '/media/');
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(GenericProvider::class);
    }

    public function it_implements_provider_interface(): void
    {
        $this->shouldHaveType(ProviderInterface::class);
    }

    public function it_renders(MediaInterface $media, Environment $twigEngine): void
    {
        $twigEngine->render('@Template', ['media' => $media, 'config' => []])->willReturn('content');

        $this->render($media, '@Template', ['config' => []])->shouldReturn('content');
    }

    public function it_uploads(MediaInterface $media, MediaUploaderInterface $uploader): void
    {
        $uploader->upload($media, '/media/')->shouldNotBeCalled();
    }
}
