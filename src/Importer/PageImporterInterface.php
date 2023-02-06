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
    public const CODE_COLUMN = 'code';

    public const SECTIONS_COLUMN = 'sections';

    public const CHANNELS_COLUMN = 'channels';

    public const PRODUCTS_COLUMN = 'products';

    public const SLUG_COLUMN = 'slug__locale__';

    public const NAME_COLUMN = 'name__locale__';

    public const IMAGE_COLUMN = 'image__locale__';

    public const META_KEYWORDS_COLUMN = 'meta_keywords__locale__';

    public const META_DESCRIPTION_COLUMN = 'meta_description__locale__';

    public const CONTENT_COLUMN = 'content__locale__';

    public const BREADCRUMB_COLUMN = 'breadcrumb__locale__';

    public const NAME_WHEN_LINKED_COLUMN = 'name_when_linked__locale__';

    public const DESCRIPTION_WHEN_LINKED_COLUMN = 'description_when_linked__locale__';
}
