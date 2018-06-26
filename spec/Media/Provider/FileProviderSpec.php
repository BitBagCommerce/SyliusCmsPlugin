<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Media\Provider;

use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use BitBag\SyliusCmsPlugin\Media\Provider\FileProvider;
use BitBag\SyliusCmsPlugin\Media\Provider\ProviderInterface;
use BitBag\SyliusCmsPlugin\Uploader\MediaUploaderInterface;
use PhpSpec\ObjectBehavior;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

final class FileProviderSpec extends ObjectBehavior
{
    function let(
        MediaUploaderInterface $uploader,
        EngineInterface $twigEngine
    ) {
        $this->beConstructedWith($uploader, $twigEngine, '@Template', '/media/');
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(FileProvider::class);
    }

    function it_implements_provider_interface(): void
    {
        $this->shouldHaveType(ProviderInterface::class);
    }

    public function it_renders(MediaInterface $media, EngineInterface $twigEngine): void
    {
        $twigEngine->render('@Template', ['media' => $media, 'config' => []])->willReturn('content');

        $this->render($media, ['config' => []])->shouldReturn('content');
    }

    public function it_uploads(MediaInterface $media, MediaUploaderInterface $uploader): void
    {
        $uploader->upload($media, '/media/')->shouldNotBeCalled();
    }
}
