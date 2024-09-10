<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Renderer\ContentElement;

use Sylius\CmsPlugin\Entity\ContentConfigurationInterface;
use Sylius\CmsPlugin\Form\Type\ContentElements\SpacerContentElementType;

final class SpacerContentElementRenderer extends AbstractContentElement
{
    public function supports(ContentConfigurationInterface $contentConfiguration): bool
    {
        return SpacerContentElementType::TYPE === $contentConfiguration->getType();
    }

    public function render(ContentConfigurationInterface $contentConfiguration): string
    {
        $configuration = (int) $contentConfiguration->getConfiguration()['spacer'];

        return $this->twig->render('@SyliusCmsPlugin/Shop/ContentElement/index.html.twig', [
            'content_element' => $this->template,
            'spacer_height' => $configuration,
        ]);
    }
}
