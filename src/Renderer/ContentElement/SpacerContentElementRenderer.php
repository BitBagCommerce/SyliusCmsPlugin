<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Sylius\CmsPlugin\Renderer\ContentElement;

use Sylius\CmsPlugin\Entity\ContentConfigurationInterface;
use Sylius\CmsPlugin\Form\Type\ContentElements\SpacerContentElementType;
use Twig\Environment;

final class SpacerContentElementRenderer implements ContentElementRendererInterface
{
    public function __construct(private Environment $twig)
    {
    }

    public function supports(ContentConfigurationInterface $contentConfiguration): bool
    {
        return SpacerContentElementType::TYPE === $contentConfiguration->getType();
    }

    public function render(ContentConfigurationInterface $contentConfiguration): string
    {
        $configuration = (int) $contentConfiguration->getConfiguration()['spacer'];

        return $this->twig->render('@BitBagSyliusCmsPlugin/Shop/ContentElement/index.html.twig', [
            'content_element' => '@BitBagSyliusCmsPlugin/Shop/ContentElement/_spacer.html.twig',
            'spacer_height' => $configuration,
        ]);
    }
}
