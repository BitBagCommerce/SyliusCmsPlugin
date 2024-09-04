<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Importer;

use Doctrine\ORM\EntityManagerInterface;
use Sylius\CmsPlugin\Entity\PageInterface;
use Sylius\CmsPlugin\Resolver\Importer\ImporterChannelsResolverInterface;
use Sylius\CmsPlugin\Resolver\Importer\ImporterCollectionsResolverInterface;
use Sylius\CmsPlugin\Resolver\ResourceResolverInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Webmozart\Assert\Assert;

final class PageImporter extends AbstractImporter implements PageImporterInterface
{
    public function __construct(
        private ResourceResolverInterface $pageResourceResolver,
        private LocaleContextInterface $localeContext,
        private ImporterCollectionsResolverInterface $importerCollectionsResolver,
        private ImporterChannelsResolverInterface $importerChannelsResolver,
        ValidatorInterface $validator,
        private EntityManagerInterface $entityManager,
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
        $page->setName($this->getColumnValue(self::NAME_COLUMN, $row));
        $page->setEnabled((bool) $this->getColumnValue(self::ENABLED_COLUMN, $row));

        foreach ($this->getAvailableLocales($this->getTranslatableColumns(), array_keys($row)) as $locale) {
            $page->setCurrentLocale($locale);
            $page->setSlug($this->getTranslatableColumnValue(self::SLUG_COLUMN, $locale, $row));
            $page->setTitle($this->getTranslatableColumnValue(self::META_TITLE_COLUMN, $locale, $row));
            $page->setMetaKeywords($this->getTranslatableColumnValue(self::META_KEYWORDS_COLUMN, $locale, $row));
            $page->setMetaDescription($this->getTranslatableColumnValue(self::META_DESCRIPTION_COLUMN, $locale, $row));
        }

        $this->importerCollectionsResolver->resolve($page, $this->getColumnValue(self::COLLECTIONS_COLUMN, $row));
        $this->importerChannelsResolver->resolve($page, $this->getColumnValue(self::CHANNELS_COLUMN, $row));

        $this->validateResource($page, ['cms']);

        $this->entityManager->persist($page);
        $this->entityManager->flush();
    }

    public function getResourceCode(): string
    {
        return 'page';
    }

    private function getTranslatableColumns(): array
    {
        return [
            self::SLUG_COLUMN,
            self::META_TITLE_COLUMN,
            self::META_KEYWORDS_COLUMN,
            self::META_DESCRIPTION_COLUMN,
        ];
    }
}
