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

interface PageImporterInterface extends ImporterInterface
{
    const CODE_COLUMN = 'code';
    const SECTIONS_COLUMN = 'sections';
    const CHANNELS_COLUMN = 'channels';
    const PRODUCTS_COLUMN = 'products';
    const SLUG_COLUMN = 'slug__locale__';
    const NAME_COLUMN = 'name__locale__';
    const IMAGE_COLUMN = 'image__locale__';
    const META_KEYWORDS_COLUMN = 'meta_keywords__locale__';
    const META_DESCRIPTION_COLUMN = 'meta_description__locale__';
    const CONTENT_COLUMN = 'content__locale__';
}
