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
use BitBag\SyliusCmsPlugin\Resolver\ImporterChannelsResolverInterface;
use BitBag\SyliusCmsPlugin\Resolver\ImporterCollectionsResolverInterface;
use BitBag\SyliusCmsPlugin\Resolver\ImporterProductsResolverInterface;
use BitBag\SyliusCmsPlugin\Resolver\ResourceResolverInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Webmozart\Assert\Assert;

final class BlockImporter extends AbstractImporter implements BlockImporterInterface
{
    public function __construct(
        private ResourceResolverInterface $blockResourceResolver,
        private LocaleContextInterface $localeContext,
        private ImporterCollectionsResolverInterface $importerCollectionsResolver,
        private ImporterChannelsResolverInterface $importerChannelsResolver,
        private ImporterProductsResolverInterface $importerProductsResolver,
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
        $block->setFallbackLocale($this->localeContext->getLocaleCode());

        foreach ($this->getAvailableLocales($this->getTranslatableColumns(), array_keys($row)) as $locale) {
            $block->setCurrentLocale($locale);
            $block->setName($this->getTranslatableColumnValue(self::NAME_COLUMN, $locale, $row));
            $block->setLink($this->getTranslatableColumnValue(self::LINK_COLUMN, $locale, $row));
            $block->setContent($this->getTranslatableColumnValue(self::CONTENT_COLUMN, $locale, $row));
        }

        $this->importerCollectionsResolver->resolve($block, $this->getColumnValue(self::COLLECTIONS_COLUMN, $row));
        $this->importerChannelsResolver->resolve($block, $this->getColumnValue(self::CHANNELS_COLUMN, $row));
        $this->importerProductsResolver->resolve($block, $this->getColumnValue(self::PRODUCTS_COLUMN, $row));

        $this->validateResource($block, ['bitbag']);
        $this->blockRepository->add($block);
    }

    public function getResourceCode(): string
    {
        return 'block';
    }

    private function getTranslatableColumns(): array
    {
        return [
            self::NAME_COLUMN,
            self::CONTENT_COLUMN,
            self::LINK_COLUMN,
        ];
    }
}
