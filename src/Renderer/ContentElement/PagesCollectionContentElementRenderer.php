<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Sylius\CmsPlugin\Renderer\ContentElement;

use Sylius\CmsPlugin\Entity\CollectionInterface;
use Sylius\CmsPlugin\Entity\ContentConfigurationInterface;
use Sylius\CmsPlugin\Form\Type\ContentElements\PagesCollectionContentElementType;
use Sylius\CmsPlugin\Repository\CollectionRepositoryInterface;
use Twig\Environment;

final class PagesCollectionContentElementRenderer implements ContentElementRendererInterface
{
    public function __construct(
        private Environment $twig,
        private CollectionRepositoryInterface $collectionRepository,
    ) {
    }

    public function supports(ContentConfigurationInterface $contentConfiguration): bool
    {
        return PagesCollectionContentElementType::TYPE === $contentConfiguration->getType();
    }

    public function render(ContentConfigurationInterface $contentConfiguration): string
    {
        $code = $contentConfiguration->getConfiguration()['pages_collection'];
        if (null === $code) {
            return '';
        }

        /** @var CollectionInterface|null $collection */
        $collection = $this->collectionRepository->findOneBy(['code' => $code]);

        return $this->twig->render('@BitBagSyliusCmsPlugin/Shop/ContentElement/index.html.twig', [
            'content_element' => '@BitBagSyliusCmsPlugin/Shop/ContentElement/_pages_collection.html.twig',
            'collection' => $collection?->getPages(),
        ]);
    }
}
