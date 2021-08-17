<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
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

    public const IMAGE_CODE_COLUMN = 'imagecode__locale__';

    public const META_KEYWORDS_COLUMN = 'metakeywords__locale__';

    public const META_DESCRIPTION_COLUMN = 'metadescription__locale__';

    public const CONTENT_COLUMN = 'content__locale__';

    public const BREADCRUMB_COLUMN = 'breadcrumb__locale__';

    public const NAME_WHEN_LINKED_COLUMN = 'namewhenlinked__locale__';

    public const DESCRIPTION_WHEN_LINKED_COLUMN = 'descriptionwhenlinked__locale__';
}
