<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\MediaProvider;

use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use BitBag\SyliusCmsPlugin\Uploader\MediaUploaderInterface;
use Twig\Environment;

final class GenericProvider implements ProviderInterface
{
    public function __construct(
        private MediaUploaderInterface $uploader,
        private Environment $twigEngine,
        private string $template,
        private string $pathPrefix,
        ) {
    }

    public function getTemplate(): string
    {
        return $this->template;
    }

    public function render(
        MediaInterface $media,
        ?string $template = null,
        array $options = [],
        ): string {
        return $this->twigEngine->render($template ?? $this->template, array_merge(['media' => $media], $options));
    }

    public function upload(MediaInterface $media): void
    {
        $this->uploader->upload($media, $this->pathPrefix);
    }
}
