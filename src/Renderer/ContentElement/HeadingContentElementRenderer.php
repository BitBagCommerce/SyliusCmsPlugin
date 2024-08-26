<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Sylius\CmsPlugin\Renderer\ContentElement;

use Sylius\CmsPlugin\Entity\ContentConfigurationInterface;
use Sylius\CmsPlugin\Form\Type\ContentElements\HeadingContentElementType;
use Twig\Environment;

final class HeadingContentElementRenderer implements ContentElementRendererInterface
{
    public function __construct(private Environment $twig)
    {
    }

    public function supports(ContentConfigurationInterface $contentConfiguration): bool
    {
        return HeadingContentElementType::TYPE === $contentConfiguration->getType();
    }

    public function render(ContentConfigurationInterface $contentConfiguration): string
    {
        $configuration = $contentConfiguration->getConfiguration();
        $headingType = $configuration['heading_type'];
        $headingContent = $configuration['heading'];

        return $this->twig->render('@BitBagSyliusCmsPlugin/Shop/ContentElement/index.html.twig', [
            'content_element' => '@BitBagSyliusCmsPlugin/Shop/ContentElement/_heading.html.twig',
            'heading_type' => $headingType,
            'heading_content' => $headingContent,
        ]);
    }
}
