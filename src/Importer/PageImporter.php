<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Importer;

use BitBag\SyliusCmsPlugin\Downloader\ImageDownloaderInterface;
use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use BitBag\SyliusCmsPlugin\Entity\PageTranslationInterface;
use BitBag\SyliusCmsPlugin\Resolver\ImporterChannelsResolverInterface;
use BitBag\SyliusCmsPlugin\Resolver\ImporterProductsResolverInterface;
use BitBag\SyliusCmsPlugin\Resolver\ImporterSectionsResolverInterface;
use BitBag\SyliusCmsPlugin\Resolver\MediaProviderResolverInterface;
use BitBag\SyliusCmsPlugin\Resolver\ResourceResolverInterface;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Webmozart\Assert\Assert;

final class PageImporter extends AbstractImporter implements PageImporterInterface
{
    /** @var ResourceResolverInterface */
    private $pageResourceResolver;

    /** @var ResourceResolverInterface */
    private $sectionResolver;

    /** @var LocaleContextInterface */
    private $localeContext;

    /** @var ImageDownloaderInterface */
    private $imageDownloader;

    /** @var FactoryInterface */
    private $mediaFactory;

    /** @var MediaProviderResolverInterface */
    private $mediaProviderResolver;

    /** @var ImporterSectionsResolverInterface */
    private $importerSectionsResolver;

    /** @var ImporterChannelsResolverInterface */
    private $importerChannelsResolver;

    /** @var ImporterProductsResolverInterface */
    private $importerProductsResolver;

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(
        ResourceResolverInterface $pageResourceResolver,
        ResourceResolverInterface $sectionResolver,
        LocaleContextInterface $localeContext,
        ImageDownloaderInterface $imageDownloader,
        FactoryInterface $mediaFactory,
        MediaProviderResolverInterface $mediaProviderResolver,
        ImporterSectionsResolverInterface $importerSectionsResolver,
        ImporterChannelsResolverInterface $importerChannelsResolver,
        ImporterProductsResolverInterface $importerProductsResolver,
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager,
    ) {
        parent::__construct($validator);

        $this->pageResourceResolver = $pageResourceResolver;
        $this->sectionResolver = $sectionResolver;
        $this->localeContext = $localeContext;
        $this->imageDownloader = $imageDownloader;
        $this->mediaFactory = $mediaFactory;
        $this->mediaProviderResolver = $mediaProviderResolver;
        $this->importerSectionsResolver = $importerSectionsResolver;
        $this->importerChannelsResolver = $importerChannelsResolver;
        $this->importerProductsResolver = $importerProductsResolver;
        $this->entityManager = $entityManager;
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

        foreach ($this->getAvailableLocales($this->getTranslatableColumns(), array_keys($row)) as $locale) {
            $page->setCurrentLocale($locale);
            $page->setSlug($this->getTranslatableColumnValue(self::SLUG_COLUMN, $locale, $row));
            $page->setName($this->getTranslatableColumnValue(self::NAME_COLUMN, $locale, $row));
            $page->setMetaKeywords($this->getTranslatableColumnValue(self::META_KEYWORDS_COLUMN, $locale, $row));
            $page->setMetaDescription($this->getTranslatableColumnValue(self::META_DESCRIPTION_COLUMN, $locale, $row));
            $page->setContent($this->getTranslatableColumnValue(self::CONTENT_COLUMN, $locale, $row));
            $page->setBreadcrumb($this->getTranslatableColumnValue(self::BREADCRUMB_COLUMN, $locale, $row));
            $page->setNameWhenLinked($this->getTranslatableColumnValue(self::NAME_WHEN_LINKED_COLUMN, $locale, $row));
            $page->setDescriptionWhenLinked($this->getTranslatableColumnValue(self::DESCRIPTION_WHEN_LINKED_COLUMN, $locale, $row));

            $url = $this->getTranslatableColumnValue(self::IMAGE_COLUMN, $locale, $row);
            $imageCode = $this->getTranslatableColumnValue(self::IMAGE_CODE_COLUMN, $locale, $row);

            if (null !== $url) {
                $this->resolveImage($page, $url ?? '', $locale, $imageCode);
            }
        }

        $this->importerSectionsResolver->resolve($page, $this->getColumnValue(self::SECTIONS_COLUMN, $row));
        $this->importerChannelsResolver->resolve($page, $this->getColumnValue(self::CHANNELS_COLUMN, $row));
        $this->importerProductsResolver->resolve($page, $this->getColumnValue(self::PRODUCTS_COLUMN, $row));

        $this->validateResource($page, ['bitbag']);

        $this->entityManager->persist($page);
        $this->entityManager->flush();
    }

    public function getResourceCode(): string
    {
        return 'page';
    }

    private function resolveImage(
        PageInterface $page,
        string $url,
        string $locale,
        string $imageCode,
    ): void {
        $downloadedImage = $this->imageDownloader->download($url);

        /** @var MediaInterface $image */
        $image = $this->mediaFactory->createNew();
        $image->setFile($downloadedImage);
        $image->setType($this->getFileType($downloadedImage));
        $image->setCode($imageCode);

        /** @var PageTranslationInterface $pageTranslation */
        $pageTranslation = $page->getTranslation($locale);
        $pageTranslation->setImage($image);

        $this->mediaProviderResolver->resolveProvider($image)->upload($image);
        $this->entityManager->persist($image);
    }

    private function getFileType(File $file): string
    {
        switch ($file->getExtension()) {
            case 'png':
            case 'jpg':
            case 'jpeg':
            case 'gif':
                return MediaInterface::IMAGE_TYPE;
            case 'mp4':
                return MediaInterface::VIDEO_TYPE;
        }

        return MediaInterface::FILE_TYPE;
    }

    private function getTranslatableColumns(): array
    {
        return [
            self::SLUG_COLUMN,
            self::NAME_COLUMN,
            self::IMAGE_COLUMN,
            self::IMAGE_CODE_COLUMN,
            self::META_KEYWORDS_COLUMN,
            self::META_DESCRIPTION_COLUMN,
            self::CONTENT_COLUMN,
            self::BREADCRUMB_COLUMN,
            self::NAME_WHEN_LINKED_COLUMN,
            self::DESCRIPTION_WHEN_LINKED_COLUMN,
        ];
    }
}
