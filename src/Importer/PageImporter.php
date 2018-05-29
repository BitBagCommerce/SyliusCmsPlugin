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
        $localeCode = $this->localeContext->getLocaleCode();

        $section->setCode($sectionCode);
        $section->setCurrentLocale($localeCode);
        $section->setFallbackLocale($localeCode);
        $section->setName($sectionName);

        $section->getId() ?: $this->entityManager->persist($section);

        $page->setCode($code);
        $page->setCurrentLocale($localeCode);
        $page->setFallbackLocale($localeCode);
        $page->setName($this->getColumnValue(self::NAME_COLUMN, $row));
        $page->setSlug($this->getColumnValue(self::SLUG_COLUMN, $row));
        $page->setMetaKeywords($this->getColumnValue(self::META_KEYWORDS_COLUMN, $row));
        $page->setMetaDescription($this->getColumnValue(self::META_DESCRIPTION_COLUMN, $row));
        $page->setContent($this->getColumnValue(self::CONTENT_COLUMN, $row));
        $page->setCreatedAt(new \DateTime($this->getColumnValue(self::CREATED_AT_COLUMN, $row)));

        if (!$page->hasSection($section)) {
            $page->addSection($section);
        }

        $this->resolveImage($page, $row);

        $page->getId() ?: $this->entityManager->persist($page);
        $this->entityManager->flush();
    }

    public function getResourceCode(): string
    {
        return 'page';
    }

    private function resolveImage(PageInterface $page, array $row): void
    {
        $url = $this->getColumnValue(self::IMAGE_COLUMN, $row);

        if (strlen($url) === 0) {
            return;
        }

        $downloadedImage = $this->imageDownloader->download($url);

        /** @var PageTranslationInterface $pageTranslation */
        $pageTranslation = $page->getTranslation($this->localeContext->getLocaleCode());

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
}
