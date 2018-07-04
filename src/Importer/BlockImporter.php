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
use BitBag\SyliusCmsPlugin\Resolver\ImporterChannelsResolverInterface;
use BitBag\SyliusCmsPlugin\Resolver\ImporterProductsResolverInterface;
use BitBag\SyliusCmsPlugin\Resolver\ImporterSectionsResolverInterface;
use BitBag\SyliusCmsPlugin\Resolver\ResourceResolverInterface;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Component\Core\Uploader\ImageUploaderInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Webmozart\Assert\Assert;

final class BlockImporter extends AbstractImporter implements BlockImporterInterface
{
    /** @var ResourceResolverInterface */
    private $blockResourceResolver;

    /** @var LocaleContextInterface */
    private $localeContext;

    /** @var ImageDownloaderInterface */
    private $imageDownloader;

    /** @var ImageUploaderInterface */
    private $imageUploader;

    /** @var ImporterSectionsResolverInterface */
    private $importerSectionsResolver;

    /** @var ImporterChannelsResolverInterface */
    private $importerChannelsResolver;

    /** @var ImporterProductsResolverInterface */
    private $importerProductsResolver;

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(
        ResourceResolverInterface $blockResourceResolver,
        LocaleContextInterface $localeContext,
        ImageDownloaderInterface $imageDownloader,
        ImageUploaderInterface $imageUploader,
        ImporterSectionsResolverInterface $importerSectionsResolver,
        ImporterChannelsResolverInterface $importerChannelsResolver,
        ImporterProductsResolverInterface $importerProductsResolver,
        EntityManagerInterface $entityManager
    ) {
        $this->blockResourceResolver = $blockResourceResolver;
        $this->localeContext = $localeContext;
        $this->imageDownloader = $imageDownloader;
        $this->imageUploader = $imageUploader;
        $this->importerSectionsResolver = $importerSectionsResolver;
        $this->importerChannelsResolver = $importerChannelsResolver;
        $this->importerProductsResolver = $importerProductsResolver;
        $this->entityManager = $entityManager;
    }

    public function import(array $row): void
    {
        /** @var string $code */
        $code = $this->getColumnValue(self::CODE_COLUMN, $row);
        Assert::notNull($code);
        $type = $this->getColumnValue(self::TYPE_COLUMN, $row);
        /** @var BlockInterface $block */
        $block = $this->blockResourceResolver->getResource($code);

        $block->setCode($code);
        $block->setType($type);
        $block->setFallbackLocale($this->localeContext->getLocaleCode());

        foreach ($this->getAvailableLocales($this->getTranslatableColumns(), array_keys($row)) as $locale) {
            $block->setCurrentLocale($locale);
            $block->setName($this->getTranslatableColumnValue(self::NAME_COLUMN, $locale, $row));
            $block->setLink($this->getTranslatableColumnValue(self::LINK_COLUMN, $locale, $row));
            $block->setContent($this->getTranslatableColumnValue(self::CONTENT_COLUMN, $locale, $row));

            $url = $this->getTranslatableColumnValue(self::IMAGE_COLUMN, $locale, $row);

            if (null !== $url && BlockInterface::IMAGE_BLOCK_TYPE === $type) {
                $this->resolveImage($block, $url ?? '', $locale);
            }
        }

        $this->importerSectionsResolver->resolve($block, $this->getColumnValue(self::SECTIONS_COLUMN, $row));
        $this->importerChannelsResolver->resolve($block, $this->getColumnValue(self::CHANNELS_COLUMN, $row));
        $this->importerProductsResolver->resolve($block, $this->getColumnValue(self::PRODUCTS_COLUMN, $row));

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
            self::LINK_COLUMN,
        ];
    }
}
