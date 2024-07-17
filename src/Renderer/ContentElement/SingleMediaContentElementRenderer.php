<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Renderer\ContentElement;

use BitBag\SyliusCmsPlugin\Entity\ContentConfigurationInterface;
use BitBag\SyliusCmsPlugin\Form\Type\ContentElements\SingleMediaContentElementType;
use BitBag\SyliusCmsPlugin\Repository\MediaRepositoryInterface;
use BitBag\SyliusCmsPlugin\Twig\Runtime\RenderMediaRuntimeInterface;
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
        $media = [
            'renderedContent' => $this->renderMediaRuntime->renderMedia($code),
            'entity' => $this->mediaRepository->findOneBy(['code' => $code]),
        ];

        return $this->twig->render('@BitBagSyliusCmsPlugin/Shop/ContentElement/index.html.twig', [
            'content_element' => '@BitBagSyliusCmsPlugin/Shop/ContentElement/_single_media.html.twig',
            'media' => $media,
        ]);
    }
}
