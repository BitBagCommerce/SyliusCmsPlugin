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
use BitBag\SyliusCmsPlugin\Entity\SectionInterface;
use BitBag\SyliusCmsPlugin\Repository\SectionRepositoryInterface;
use BitBag\SyliusCmsPlugin\Resolver\ResourceResolverInterface;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Component\Core\Uploader\ImageUploaderInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Webmozart\Assert\Assert;

final class BlockImporter extends AbstractImporter implements BlockImporterInterface
{
    /** @var ResourceResolverInterface */
    private $blockResourceResolver;

    /** @var SectionRepositoryInterface */
    private $sectionRepository;

    /** @var LocaleContextInterface */
    private $localeContext;

    /** @var ImageDownloaderInterface */
    private $imageDownloader;

    /** @var ImageUploaderInterface */
    private $imageUploader;

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(
        ResourceResolverInterface $blockResourceResolver,
        SectionRepositoryInterface $sectionRepository,
        LocaleContextInterface $localeContext,
        ImageDownloaderInterface $imageDownloader,
        ImageUploaderInterface $imageUploader,
        EntityManagerInterface $entityManager
    )
    {
        $this->blockResourceResolver = $blockResourceResolver;
        $this->sectionRepository = $sectionRepository;
        $this->localeContext = $localeContext;
        $this->imageDownloader = $imageDownloader;
        $this->imageUploader = $imageUploader;
        $this->entityManager = $entityManager;
    }

    public function import(array $row): void
    {
        $localeCode = $this->localeContext->getLocaleCode();
        /** @var string $code */
        $code = $this->getColumnValue(self::CODE_COLUMN, $row);
        Assert::notNull($code);
        $type = $this->getColumnValue(self::TYPE_COLUMN, $row);
        $sectionCode = $this->getColumnValue(self::SECTION_COLUMN, $row);
        /** @var BlockInterface $block */
        $block = $this->blockResourceResolver->getResource($code);

        $block->setCode($code);
        $block->setType($type);

        foreach ($this->getAvailableLocales($this->getTranslatableColumns(), array_keys($row)) as $locale) {
            $block->setCurrentLocale($localeCode);
            $block->setFallbackLocale($localeCode);
            $block->setName($this->getTranslatableColumnValue(self::NAME_COLUMN, $locale, $row));
            $block->setLink($this->getTranslatableColumnValue(self::LINK_COLUMN, $locale, $row));
            $block->setContent($this->getTranslatableColumnValue(self::CONTENT_COLUMN, $locale, $row));

            $url = $this->getTranslatableColumnValue(self::IMAGE_COLUMN, $locale, $row);

            if (null !== $url && BlockInterface::IMAGE_BLOCK_TYPE === $type) {
                $this->resolveImage($block, $url ?? '', $locale);
            }
        }

        if (null !== $sectionCode) {
            /** @var SectionInterface $section */
            $section = $this->sectionRepository->findOneBy(['code' => $sectionCode]);

            if (!$block->hasSection($section)) {
                $block->addSection($section);
            }
        }

        $block->getId() ?: $this->entityManager->persist($block);
        $this->entityManager->flush();
    }

    public function getResourceCode(): string
    {
        return 'block';
    }

    private function resolveImage(BlockInterface $block, string $url, string $locale): void
    {
        /** @var BlockTranslationInterface $blockTranslation */
        $blockTranslation = $block->getTranslation($locale);
        $downloadedImage = $this->imageDownloader->download($url);

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

    private function getTranslatableColumns(): array
    {
        return [
            self::NAME_COLUMN,
            self::CONTENT_COLUMN,
            self::IMAGE_COLUMN,
            self::SECTION_COLUMN,
            self::LINK_COLUMN,
        ];
    }
}
