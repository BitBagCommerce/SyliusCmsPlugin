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
use BitBag\SyliusCmsPlugin\Resolver\Importer\ImporterCollectionsResolverInterface;
use BitBag\SyliusCmsPlugin\Resolver\ResourceResolverInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Webmozart\Assert\Assert;

final class MediaImporter extends AbstractImporter implements MediaImporterInterface
{
    public function __construct(
        private ResourceResolverInterface $mediaResourceResolver,
        private LocaleContextInterface $localeContext,
        private ImporterCollectionsResolverInterface $importerCollectionsResolver,
        ValidatorInterface $validator,
        private MediaRepositoryInterface $mediaRepository,
    ) {
        parent::__construct($validator);
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

        $this->importerCollectionsResolver->resolve($media, $this->getColumnValue(self::COLLECTIONS_COLUMN, $row));

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
