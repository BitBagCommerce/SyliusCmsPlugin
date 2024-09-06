<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Renderer\ContentElement;

use Sylius\CmsPlugin\Entity\ContentConfigurationInterface;
use Sylius\CmsPlugin\Form\Type\ContentElements\SingleMediaContentElementType;
use Sylius\CmsPlugin\Repository\MediaRepositoryInterface;
use Sylius\CmsPlugin\Twig\Runtime\RenderMediaRuntimeInterface;
use Twig\Environment;

final class SingleMediaContentElementRenderer implements ContentElementRendererInterface
{
    public function __construct(
        private Environment $twig,
        private RenderMediaRuntimeInterface $renderMediaRuntime,
        private MediaRepositoryInterface $mediaRepository,
    ) {
    }

    public function supports(ContentConfigurationInterface $contentConfiguration): bool
    {
        return SingleMediaContentElementType::TYPE === $contentConfiguration->getType();
    }

    public function render(ContentConfigurationInterface $contentConfiguration): string
    {
        $code = $contentConfiguration->getConfiguration()['single_media'];
        if (null === $code) {
            return '';
        }

        $media = [
            'renderedContent' => $this->renderMediaRuntime->renderMedia($code),
            'entity' => $this->mediaRepository->findOneBy(['code' => $code]),
        ];

        return $this->twig->render('@SyliusCmsPlugin/Shop/ContentElement/index.html.twig', [
            'content_element' => '@SyliusCmsPlugin/Shop/ContentElement/_single_media.html.twig',
            'media' => $media,
        ]);
    }
}
