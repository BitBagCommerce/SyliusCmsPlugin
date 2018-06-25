<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Media\Provider;

use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use BitBag\SyliusCmsPlugin\Uploader\MediaUploaderInterface;
use Symfony\Bundle\TwigBundle\TwigEngine;

abstract class AbstractProvider implements ProviderInterface
{
    /** @var MediaUploaderInterface */
    private $uploader;

    /** @var TwigEngine */
    private $twigEngine;

    /** @var string */
    private $template;

    /** @var string */
    private $pathPrefix;

    public function __construct(MediaUploaderInterface $uploader, TwigEngine $twigEngine, string $template, string $pathPrefix)
    {
        $this->uploader = $uploader;
        $this->twigEngine = $twigEngine;
        $this->template = $template;
        $this->pathPrefix = $pathPrefix;
    }

    public function render(MediaInterface $media, array $options = []): string
    {
        return $this->twigEngine->render($this->template, array_merge(['media' => $media], $options));
    }

    public function upload(MediaInterface $media): void
    {
        $this->uploader->upload($media, $this->pathPrefix);
    }
}
