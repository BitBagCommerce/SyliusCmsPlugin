<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Renderer\ContentElement;

use BitBag\SyliusCmsPlugin\Entity\ContentConfigurationInterface;
use BitBag\SyliusCmsPlugin\Form\Type\ContentElements\TextareaContentElementType;
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
