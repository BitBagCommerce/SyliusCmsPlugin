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
use BitBag\SyliusCmsPlugin\Entity\BlockImage;
use BitBag\SyliusCmsPlugin\Entity\BlockInterface;
use BitBag\SyliusCmsPlugin\Entity\BlockTranslationInterface;
use BitBag\SyliusCmsPlugin\Resolver\ResourceResolverInterface;
use BitBag\SyliusCmsPlugin\Entity\SectionInterface;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Component\Core\Formatter\StringInflector;
use Sylius\Component\Core\Uploader\ImageUploader;
use Sylius\Component\Locale\Context\LocaleContextInterface;

final class BlockImporter extends AbstractImporter implements BlockImporterInterface
{
    /** @var ResourceResolverInterface */
    private $blockResourceResolver;

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
        ResourceResolverInterface $blockResourceResolver,
        ResourceResolverInterface $sectionResolver,
        LocaleContextInterface $localeContext,
        ImageDownloaderInterface $imageDownloader,
        ImageUploader $imageUploader,
        EntityManagerInterface $entityManager
    ) {
        $this->blockResourceResolver = $blockResourceResolver;
        $this->sectionResolver = $sectionResolver;
        $this->localeContext = $localeContext;
        $this->imageDownloader = $imageDownloader;
        $this->imageUploader = $imageUploader;
        $this->entityManager = $entityManager;
    }

    public function import(array $row): void
    {
        $code = $this->getColumnValue(self::CODE_COLUMN, $row) ?: StringInflector::nameToCode($this->getColumnValue(self::NAME_COLUMN, $row));
        
        /** @var BlockInterface $block */
        $block = $this->blockResourceResolver->getResource($code);

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

        $block->setCode($code);
        $block->setCurrentLocale($localeCode);
        $block->setFallbackLocale($localeCode);
        $block->setName($this->getColumnValue(self::NAME_COLUMN, $row));
        $block->setLink($this->getColumnValue(self::LINK_COLUMN, $row));
        $block->setType($this->getColumnValue(self::TYPE_COLUMN, $row));
        $block->setContent($this->getColumnValue(self::CONTENT_COLUMN, $row));

        if (!$block->hasSection($section)) {
            $block->addSection($section);
        }

        $this->resolveImage($block, $row);

        $block->getId() ?: $this->entityManager->persist($block);
        $this->entityManager->flush();
    }

    public function getResourceCode(): string
    {
        return 'block';
    }

    private function resolveImage(BlockInterface $block, array $row): void
    {
        $url = $this->getColumnValue(self::IMAGE_COLUMN, $row);

        if (strlen($url) === 0) {
            return;
        }

        $downloadedImage = $this->imageDownloader->download($url);

        /** @var BlockTranslationInterface $blockTranslation */
        $blockTranslation = $block->getTranslation($this->localeContext->getLocaleCode());

        if (null !== $blockImage = $blockTranslation->getImage()) {
            $this->imageUploader->remove($blockTranslation->getImage()->getPath());
        } else {
            $blockImage = new BlockImage();
        }

        $blockImage->setFile($downloadedImage);
        $blockImage->setOwner($blockTranslation);

        $this->imageUploader->upload($blockImage);
        $this->entityManager->persist($blockImage);
    }
}
