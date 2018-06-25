<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Importer;

use BitBag\SyliusCmsPlugin\Downloader\ImageDownloaderInterface;
use BitBag\SyliusCmsPlugin\Resolver\ResourceResolverInterface;
use BitBag\SyliusCmsPlugin\Entity\PageImage;
use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use BitBag\SyliusCmsPlugin\Entity\PageTranslationInterface;
use BitBag\SyliusCmsPlugin\Entity\SectionInterface;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Component\Core\Formatter\StringInflector;
use Sylius\Component\Core\Uploader\ImageUploader;
use Sylius\Component\Locale\Context\LocaleContextInterface;

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

    /** @var ImageUploader */
    private $imageUploader;

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(
        ResourceResolverInterface $pageResourceResolver,
        ResourceResolverInterface $sectionResolver,
        LocaleContextInterface $localeContext,
        ImageDownloaderInterface $imageDownloader,
        ImageUploader $imageUploader,
        EntityManagerInterface $entityManager
    ) {
        $this->pageResourceResolver = $pageResourceResolver;
        $this->sectionResolver = $sectionResolver;
        $this->localeContext = $localeContext;
        $this->imageDownloader = $imageDownloader;
        $this->imageUploader = $imageUploader;
        $this->entityManager = $entityManager;
    }

    public function import(array $row): void
    {
        $code = $this->getColumnValue(self::CODE_COLUMN, $row) ?: StringInflector::nameToCode($this->getColumnValue(self::NAME_COLUMN, $row));

        /** @var PageInterface $page */
        $page = $this->pageResourceResolver->getResource($code);

        $sectionName = $this->getColumnValue(self::SECTION_COLUMN, $row);
        $sectionCode = StringInflector::nameToCode($sectionName);

        /** @var SectionInterface $section */
        $section = $this->sectionResolver->getResource($sectionCode);

        $section->setCode($sectionCode);

        $page->setCode($code);

        foreach ($this->getAvailableLocales($this->getTranslatableColumns(), array_keys($row)) as $locale) {
            $page->setCurrentLocale($locale);
            $page->setFallbackLocale($locale);

            $section->setCurrentLocale($locale);
            $section->setFallbackLocale($locale);

            $section->setName($this->getTranslatableColumnValue(self::SECTION_COLUMN, $locale, $row));

            $page->setName($this->getTranslatableColumnValue(self::NAME_COLUMN, $locale, $row));
            $page->setSlug($this->getTranslatableColumnValue(self::SLUG_COLUMN, $locale, $row));
            $page->setMetaKeywords($this->getTranslatableColumnValue(self::META_KEYWORDS_COLUMN, $locale, $row));
            $page->setMetaDescription($this->getTranslatableColumnValue(self::META_DESCRIPTION_COLUMN, $locale, $row));
            $page->setContent($this->getTranslatableColumnValue(self::CONTENT_COLUMN, $locale, $row));

            $this->resolveImage($page, $this->getTranslatableColumnValue(self::IMAGE_COLUMN, $locale, $row), $locale);
        }

        $page->setCreatedAt(new \DateTime($this->getColumnValue(self::CREATED_AT_COLUMN, $row)));

        $section->getId() ?: $this->entityManager->persist($section);

        if (!$page->hasSection($section)) {
            $page->addSection($section);
        }

        $page->getId() ?: $this->entityManager->persist($page);

        $this->entityManager->flush();
    }

    public function getResourceCode(): string
    {
        return 'page';
    }

    private function resolveImage(PageInterface $page, string $url, string $locale): void
    {
        if (strlen($url) === 0) {
            return;
        }

        $downloadedImage = $this->imageDownloader->download($url);

        /** @var PageTranslationInterface $pageTranslation */
        $pageTranslation = $page->getTranslation($locale);

        if (null !== $pageImage = $pageTranslation->getImage()) {
            $this->imageUploader->remove($pageTranslation->getImage()->getPath());
        } else {
            $pageImage = new PageImage();
        }

        $pageImage->setFile($downloadedImage);
        $pageImage->setOwner($pageTranslation);

        $this->imageUploader->upload($pageImage);
        $this->entityManager->persist($pageImage);
    }

    private function getTranslatableColumns(): array
    {
        return [
            self::NAME_COLUMN,
            self::SLUG_COLUMN,
            self::META_KEYWORDS_COLUMN,
            self::META_DESCRIPTION_COLUMN,
            self::CONTENT_COLUMN,
            self::IMAGE_COLUMN,
            self::SECTION_COLUMN
        ];
    }
}
