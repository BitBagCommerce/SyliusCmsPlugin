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

use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use BitBag\SyliusCmsPlugin\Resolver\ImporterProductsResolverInterface;
use BitBag\SyliusCmsPlugin\Resolver\ImporterSectionsResolverInterface;
use BitBag\SyliusCmsPlugin\Resolver\ResourceResolverInterface;
use Doctrine\ORM\EntityManagerInterface;
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

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(
        ResourceResolverInterface $mediaResourceResolver,
        LocaleContextInterface $localeContext,
        ImporterSectionsResolverInterface $importerSectionsResolver,
        ImporterProductsResolverInterface $importerProductsResolver,
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager
    ) {
        parent::__construct($validator);

        $this->mediaResourceResolver = $mediaResourceResolver;
        $this->localeContext = $localeContext;
        $this->importerSectionsResolver = $importerSectionsResolver;
        $this->importerProductsResolver = $importerProductsResolver;
        $this->entityManager = $entityManager;
    }

    public function import(array $row): void
    {
        /** @var string $code */
        $code = $this->getColumnValue(self::CODE_COLUMN, $row);
        Assert::notNull($code);
        /** @var MediaInterface $media */
        $media = $this->mediaResourceResolver->getResource($code);

        $media->setCode($code);
        $media->setFallbackLocale($this->localeContext->getLocaleCode());

        foreach ($this->getAvailableLocales($this->getTranslatableColumns(), array_keys($row)) as $locale) {
            $media->setCurrentLocale($locale);
            $media->setName($this->getTranslatableColumnValue(self::NAME_COLUMN, $locale, $row));
            $media->setDescription($this->getTranslatableColumnValue(self::DESCRIPTION_COLUMN, $locale, $row));
            $media->setAlt($this->getTranslatableColumnValue(self::ALT_COLUMN, $locale, $row));
        }

        $this->importerSectionsResolver->resolve($media, $this->getColumnValue(self::SECTIONS_COLUMN, $row));
        $this->importerProductsResolver->resolve($media, $this->getColumnValue(self::PRODUCTS_COLUMN, $row));

        $this->validateResource($media, ['bitbag']);

        $media->getId() ?: $this->entityManager->persist($media);
        $this->entityManager->flush();
    }

    public function getResourceCode(): string
    {
        return 'media';
    }

    private function getTranslatableColumns(): array
    {
        return [
            self::NAME_COLUMN,
            self::DESCRIPTION_COLUMN,
            self::ALT_COLUMN,
        ];
    }
}
