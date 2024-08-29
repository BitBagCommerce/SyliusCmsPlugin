<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Renderer\ContentElement;

use Sylius\CmsPlugin\Entity\ContentConfigurationInterface;
use Sylius\CmsPlugin\Form\Type\ContentElements\TextareaContentElementType;
use Twig\Environment;

final class TextareaContentElementRenderer implements ContentElementRendererInterface
{
    public function __construct(private Environment $twig)
    {
    }

    public function supports(ContentConfigurationInterface $contentConfiguration): bool
    {
        return TextareaContentElementType::TYPE === $contentConfiguration->getType();
    }

    public function render(ContentConfigurationInterface $contentConfiguration): string
    {
        return $this->twig->render('@BitBagSyliusCmsPlugin/Shop/ContentElement/index.html.twig', [
            'content_element' => '@BitBagSyliusCmsPlugin/Shop/ContentElement/_textarea.html.twig',
            'content' => $contentConfiguration->getConfiguration()['textarea'],
        ]);
    }
}
