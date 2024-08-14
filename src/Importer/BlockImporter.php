<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Importer;

use BitBag\SyliusCmsPlugin\Entity\BlockInterface;
use BitBag\SyliusCmsPlugin\Repository\BlockRepositoryInterface;
use BitBag\SyliusCmsPlugin\Resolver\Importer\ImporterChannelsResolverInterface;
use BitBag\SyliusCmsPlugin\Resolver\Importer\ImporterCollectionsResolverInterface;
use BitBag\SyliusCmsPlugin\Resolver\Importer\ImporterLocalesResolverInterface;
use BitBag\SyliusCmsPlugin\Resolver\Importer\ImporterProductsInTaxonsResolverInterface;
use BitBag\SyliusCmsPlugin\Resolver\Importer\ImporterProductsResolverInterface;
use BitBag\SyliusCmsPlugin\Resolver\Importer\ImporterTaxonsResolverInterface;
use BitBag\SyliusCmsPlugin\Resolver\ResourceResolverInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Webmozart\Assert\Assert;

final class BlockImporter extends AbstractImporter implements BlockImporterInterface
{
    public function __construct(
        private ResourceResolverInterface $blockResourceResolver,
        private ImporterCollectionsResolverInterface $importerCollectionsResolver,
        private ImporterChannelsResolverInterface $importerChannelsResolver,
        private ImporterLocalesResolverInterface $importerLocalesResolver,
        private ImporterProductsResolverInterface $importerProductsResolver,
        private ImporterTaxonsResolverInterface $importerTaxonsResolver,
        private ImporterProductsInTaxonsResolverInterface $importerProductsInTaxonsResolver,
        ValidatorInterface $validator,
        private BlockRepositoryInterface $blockRepository,
    ) {
        parent::__construct($validator);
    }

    public function import(array $row): void
    {
        /** @var string|null $code */
        $code = $this->getColumnValue(self::CODE_COLUMN, $row);
        Assert::notNull($code);
        /** @var BlockInterface $block */
        $block = $this->blockResourceResolver->getResource($code);
        $block->setCode($code);
        $block->setName($this->getColumnValue(self::NAME_COLUMN, $row));
        $block->setEnabled((bool) $this->getColumnValue(self::ENABLED_COLUMN, $row));

        $this->importerCollectionsResolver->resolve($block, $this->getColumnValue(self::COLLECTIONS_COLUMN, $row));
        $this->importerChannelsResolver->resolve($block, $this->getColumnValue(self::CHANNELS_COLUMN, $row));
        $this->importerLocalesResolver->resolve($block, $this->getColumnValue(self::LOCALES_COLUMN, $row));
        $this->importerProductsResolver->resolve($block, $this->getColumnValue(self::PRODUCTS_COLUMN, $row));
        $this->importerTaxonsResolver->resolve($block, $this->getColumnValue(self::TAXONS_COLUMN, $row));
        $this->importerProductsInTaxonsResolver->resolve($block, $this->getColumnValue(self::PRODUCTS_IN_TAXONS_COLUMN, $row));

        $this->validateResource($block, ['bitbag']);
        $this->blockRepository->add($block);
    }

    public function getResourceCode(): string
    {
        return 'block';
    }
}
