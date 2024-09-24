<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Factory;

use Sylius\CmsPlugin\Entity\ContentConfiguration;

final class ContentElementFactory
{
    public static function createHeadingContentElement(
        ?string $locale,
        ?string $headingType,
        ?string $headingContent,
    ): ?ContentConfiguration {
        if (null === $headingContent) {
            return null;
        }

        $contentConfiguration = new ContentConfiguration();
        $contentConfiguration->setLocale($locale ?? 'en_US');
        $contentConfiguration->setType('heading');
        $contentConfiguration->setConfiguration([
            'heading_type' => $headingType ?? 'h1',
            'heading' => $headingContent,
        ]);

        return $contentConfiguration;
    }

    public static function createTextareaContentElement(?string $locale, ?string $content): ?ContentConfiguration
    {
        if (null === $content) {
            return null;
        }

        $contentConfiguration = new ContentConfiguration();
        $contentConfiguration->setLocale($locale ?? 'en_US');
        $contentConfiguration->setType('textarea');
        $contentConfiguration->setConfiguration([
            'textarea' => $content,
        ]);

        return $contentConfiguration;
    }

    public static function createProductsGridContentElement(?string $locale, ?string $codes): ?ContentConfiguration
    {
        if (null === $codes) {
            return null;
        }

        $productsCodes = explode(',', $codes);
        $productsCodes = array_map(static function (string $element): string {
            return trim($element);
        }, $productsCodes);

        $contentConfiguration = new ContentConfiguration();
        $contentConfiguration->setLocale($locale ?? 'en_US');
        $contentConfiguration->setType('products_grid');
        $contentConfiguration->setConfiguration([
            'products_grid' => [
                'products' => $productsCodes,
            ],
        ]);

        return $contentConfiguration;
    }

    public static function createSingleMediaContentElement(?string $locale, ?string $code): ?ContentConfiguration
    {
        if (null === $code) {
            return null;
        }

        $contentConfiguration = new ContentConfiguration();
        $contentConfiguration->setLocale($locale ?? 'en_US');
        $contentConfiguration->setType('single_media');
        $contentConfiguration->setConfiguration([
            'single_media' => $code,
        ]);

        return $contentConfiguration;
    }
}
