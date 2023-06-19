<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Importer;

use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use BitBag\SyliusCmsPlugin\Repository\MediaRepositoryInterface;
use BitBag\SyliusCmsPlugin\Resolver\ImporterProductsResolverInterface;
use BitBag\SyliusCmsPlugin\Resolver\ImporterSectionsResolverInterface;
use BitBag\SyliusCmsPlugin\Resolver\ResourceResolverInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Webmozart\Assert\Assert;

final class MediaImporter extends AbstractImporter implements MediaImporterInterface
{
    /** @var ResourceResolverInterface */
    private $mediaResourceResolver;

    /** @var LocaleContextInterface */
    private $localeContext;

    /** @var ImporterSectionsResolverInterface */
    private $importerSectionsResolver;

    /** @var ImporterProductsResolverInterface */
    private $importerProductsResolver;

    /** @var MediaRepositoryInterface */
    private $mediaRepository;

    public function __construct(
        ResourceResolverInterface $mediaResourceResolver,
        LocaleContextInterface $localeContext,
        ImporterSectionsResolverInterface $importerSectionsResolver,
        ImporterProductsResolverInterface $importerProductsResolver,
        ValidatorInterface $validator,
        MediaRepositoryInterface $mediaRepository,
    ) {
        parent::__construct($validator);

        $this->mediaResourceResolver = $mediaResourceResolver;
        $this->localeContext = $localeContext;
        $this->importerSectionsResolver = $importerSectionsResolver;
        $this->importerProductsResolver = $importerProductsResolver;
        $this->mediaRepository = $mediaRepository;
    }

    public function import(array $row): void
    {
        /** @var string|null $code */
        $code = $this->getColumnValue(self::CODE_COLUMN, $row);
        Assert::notNull($code);
        /** @var MediaInterface $media */
        $media = $this->mediaResourceResolver->getResource($code);

        $media->setCode($code);
        $media->setType($this->getColumnValue(self::TYPE_COLUMN, $row));
        $media->setFallbackLocale($this->localeContext->getLocaleCode());

        foreach ($this->getAvailableLocales($this->getTranslatableColumns(), array_keys($row)) as $locale) {
            $media->setCurrentLocale($locale);
            $media->setName($this->getTranslatableColumnValue(self::NAME_COLUMN, $locale, $row));
            $media->setContent($this->getTranslatableColumnValue(self::CONTENT_COLUMN, $locale, $row));
            $media->setAlt($this->getTranslatableColumnValue(self::ALT_COLUMN, $locale, $row));
        }

        $this->importerSectionsResolver->resolve($media, $this->getColumnValue(self::SECTIONS_COLUMN, $row));
        $this->importerProductsResolver->resolve($media, $this->getColumnValue(self::PRODUCTS_COLUMN, $row));

        $this->validateResource($media, ['bitbag']);

        $this->mediaRepository->add($media);
    }

    public function getResourceCode(): string
    {
        return 'media';
    }

    private function getTranslatableColumns(): array
    {
        return [
            self::NAME_COLUMN,
            self::CONTENT_COLUMN,
            self::ALT_COLUMN,
        ];
    }
}
