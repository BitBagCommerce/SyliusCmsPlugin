<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Importer\Legacy;

use Sylius\CmsPlugin\Entity\BlockInterface;
use Sylius\CmsPlugin\Factory\ContentElementFactory;
use Sylius\CmsPlugin\Importer\AbstractImporter;
use Sylius\CmsPlugin\Repository\BlockRepositoryInterface;
use Sylius\CmsPlugin\Resolver\Importer\ImporterChannelsResolverInterface;
use Sylius\CmsPlugin\Resolver\Importer\ImporterCollectionsResolverInterface;
use Sylius\CmsPlugin\Resolver\ResourceResolverInterface;
use Sylius\Component\Locale\Model\LocaleInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Webmozart\Assert\Assert;

final class LegacyBlockImporter extends AbstractImporter implements LegacyBlockImporterInterface
{
    public function __construct(
        private ResourceResolverInterface $blockResourceResolver,
        private ImporterCollectionsResolverInterface $importerCollectionsResolver,
        private ImporterChannelsResolverInterface $importerChannelsResolver,
        private BlockRepositoryInterface $blockRepository,
        private RepositoryInterface $localeRepository,
        ValidatorInterface $validator,
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

        $this->importerCollectionsResolver->resolve($block, $this->getColumnValue(self::SECTIONS_COLUMN, $row));
        $this->importerChannelsResolver->resolve($block, $this->getColumnValue(self::CHANNELS_COLUMN, $row));

        $translationArray = $this->getAvailableLocales($this->getTranslatableColumns(), array_keys($row));
        foreach ($translationArray as $key => $locale) {
            if ($key === array_key_first($translationArray)) {
                $block->setName($this->getTranslatableColumnValue(self::NAME_COLUMN, $locale, $row));
            }

            $heading = ContentElementFactory::createHeadingContentElement(
                $locale,
                'h2',
                $this->getTranslatableColumnValue(self::NAME_COLUMN, $locale, $row),
            );
            if ($heading) {
                $heading->setBlock($block);
                $block->addContentElement($heading);
            }

            $singleMedia = ContentElementFactory::createSingleMediaContentElement(
                $locale,
                $this->getTranslatableColumnValue(self::IMAGE_COLUMN, $locale, $row),
            );
            if ($singleMedia) {
                $singleMedia->setBlock($block);
                $block->addContentElement($singleMedia);
            }

            $content = ContentElementFactory::createTextareaContentElement(
                $locale,
                $this->getTranslatableColumnValue(self::CONTENT_COLUMN, $locale, $row),
            );
            if ($content) {
                $content->setBlock($block);
                $block->addContentElement($content);
            }
        }

        $locales = $this->localeRepository->findAll();
        /** @var LocaleInterface $locale */
        foreach ($locales as $locale) {
            $productsGrid = ContentElementFactory::createProductsGridContentElement(
                $locale->getCode(),
                $this->getColumnValue(self::PRODUCTS_COLUMN, $row),
            );
            if ($productsGrid) {
                $productsGrid->setBlock($block);
                $block->addContentElement($productsGrid);
            }
        }

        $this->validateResource($block, ['cms']);
        $this->blockRepository->add($block);
    }

    public function getResourceCode(): string
    {
        return 'block_legacy';
    }

    private function getTranslatableColumns(): array
    {
        return [
            self::NAME_COLUMN,
            self::CONTENT_COLUMN,
            self::IMAGE_COLUMN,
        ];
    }
}
