<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Importer\Legacy;

use Doctrine\ORM\EntityManagerInterface;
use Sylius\CmsPlugin\Entity\PageInterface;
use Sylius\CmsPlugin\Factory\ContentElementFactory;
use Sylius\CmsPlugin\Importer\AbstractImporter;
use Sylius\CmsPlugin\Resolver\Importer\ImporterChannelsResolverInterface;
use Sylius\CmsPlugin\Resolver\Importer\ImporterCollectionsResolverInterface;
use Sylius\CmsPlugin\Resolver\ResourceResolverInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Component\Locale\Model\LocaleInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Webmozart\Assert\Assert;

final class LegacyPageImporter extends AbstractImporter implements LegacyPageImporterInterface
{
    public function __construct(
        private ResourceResolverInterface $pageResourceResolver,
        private LocaleContextInterface $localeContext,
        private ImporterCollectionsResolverInterface $importerCollectionsResolver,
        private ImporterChannelsResolverInterface $importerChannelsResolver,
        private EntityManagerInterface $entityManager,
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

        /** @var PageInterface $page */
        $page = $this->pageResourceResolver->getResource($code);

        $page->setCode($code);
        $page->setFallbackLocale($this->localeContext->getLocaleCode());

        $this->importerCollectionsResolver->resolve($page, $this->getColumnValue(self::SECTIONS_COLUMN, $row));
        $this->importerChannelsResolver->resolve($page, $this->getColumnValue(self::CHANNELS_COLUMN, $row));

        $translationArray = $this->getAvailableLocales($this->getTranslatableColumns(), array_keys($row));
        foreach ($translationArray as $key => $locale) {
            $page->setCurrentLocale($locale);
            $page->setSlug($this->getTranslatableColumnValue(self::SLUG_COLUMN, $locale, $row));
            $page->setMetaKeywords($this->getTranslatableColumnValue(self::META_KEYWORDS_COLUMN, $locale, $row));
            $page->setMetaDescription($this->getTranslatableColumnValue(self::META_DESCRIPTION_COLUMN, $locale, $row));

            if ($key === array_key_first($translationArray)) {
                $page->setName($this->getTranslatableColumnValue(self::NAME_COLUMN, $locale, $row));
            }

            $page->setTeaserTitle($this->getTranslatableColumnValue(self::NAME_WHEN_LINKED_COLUMN, $locale, $row));
            $page->setTeaserContent($this->getTranslatableColumnValue(self::DESCRIPTION_WHEN_LINKED_COLUMN, $locale, $row));

            $heading = ContentElementFactory::createHeadingContentElement(
                $locale,
                'h2',
                $this->getTranslatableColumnValue(self::NAME_COLUMN, $locale, $row),
            );
            if ($heading) {
                $heading->setPage($page);
                $page->addContentElement($heading);
            }

            $singleMedia = ContentElementFactory::createSingleMediaContentElement(
                $locale,
                $this->getTranslatableColumnValue(self::IMAGE_COLUMN, $locale, $row),
            );
            if ($singleMedia) {
                $singleMedia->setPage($page);
                $page->addContentElement($singleMedia);
            }

            $content = ContentElementFactory::createTextareaContentElement(
                $locale,
                $this->getTranslatableColumnValue(self::CONTENT_COLUMN, $locale, $row),
            );
            if ($content) {
                $content->setPage($page);
                $page->addContentElement($content);
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
                $productsGrid->setPage($page);
                $page->addContentElement($productsGrid);
            }
        }

        $this->validateResource($page, ['cms']);

        $this->entityManager->persist($page);
        $this->entityManager->flush();
    }

    public function getResourceCode(): string
    {
        return 'page_legacy';
    }

    private function getTranslatableColumns(): array
    {
        return [
            self::SLUG_COLUMN,
            self::NAME_COLUMN,
            self::IMAGE_COLUMN,
            self::CONTENT_COLUMN,
            self::META_KEYWORDS_COLUMN,
            self::META_DESCRIPTION_COLUMN,
            self::NAME_WHEN_LINKED_COLUMN,
            self::DESCRIPTION_WHEN_LINKED_COLUMN,
        ];
    }
}
