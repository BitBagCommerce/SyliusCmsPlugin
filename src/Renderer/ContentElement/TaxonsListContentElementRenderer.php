<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Renderer\ContentElement;

use Sylius\CmsPlugin\Entity\ContentConfigurationInterface;
use Sylius\CmsPlugin\Form\Type\ContentElements\TaxonsListContentElementType;
use Sylius\Component\Taxonomy\Repository\TaxonRepositoryInterface;

final class TaxonsListContentElementRenderer extends AbstractContentElement
{
    public function __construct(
        private TaxonRepositoryInterface $taxonRepository,
    ) {
    }

    public function supports(ContentConfigurationInterface $contentConfiguration): bool
    {
        return TaxonsListContentElementType::TYPE === $contentConfiguration->getType();
    }

    public function render(ContentConfigurationInterface $contentConfiguration): string
    {
        $configuration = $contentConfiguration->getConfiguration();
        $taxonsCodes = $configuration['taxons_list']['taxons'];
        $taxons = $this->taxonRepository->findBy(['code' => $taxonsCodes]);

        return $this->twig->render('@SyliusCmsPlugin/Shop/ContentElement/index.html.twig', [
            'content_element' => $this->template,
            'taxons' => $taxons,
        ]);
    }
}
