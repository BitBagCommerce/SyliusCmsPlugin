<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Renderer\ContentElement;

use Sylius\CmsPlugin\Entity\ContentConfigurationInterface;
use Sylius\CmsPlugin\Form\Type\ContentElements\HeadingContentElementType;

final class HeadingContentElementRenderer extends AbstractContentElement
{
    public function supports(ContentConfigurationInterface $contentConfiguration): bool
    {
        return HeadingContentElementType::TYPE === $contentConfiguration->getType();
    }

    public function render(ContentConfigurationInterface $contentConfiguration): string
    {
        $configuration = $contentConfiguration->getConfiguration();
        $headingType = $configuration['heading_type'];
        $headingContent = $configuration['heading'];

        return $this->twig->render('@SyliusCmsPlugin/Shop/ContentElement/index.html.twig', [
            'content_element' => $this->template,
            'heading_type' => $headingType,
            'heading_content' => $headingContent,
        ]);
    }
}
