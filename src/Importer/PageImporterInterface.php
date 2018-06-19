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
    const SLUG_COLUMN = 'slug';
    const NAME_COLUMN = 'name';
    const IMAGE_COLUMN = 'image';
    const SECTION_COLUMN = 'section';
    const META_KEYWORDS_COLUMN = 'meta_keywords';
    const META_DESCRIPTION_COLUMN = 'meta_description';
    const CONTENT_COLUMN = 'content';
    const CREATED_AT_COLUMN = 'created_at';
}
