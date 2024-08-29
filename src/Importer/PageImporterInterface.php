<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Importer;

interface PageImporterInterface extends ImporterInterface
{
    public const CODE_COLUMN = 'code';

    public const NAME_COLUMN = 'name';

    public const ENABLED_COLUMN = 'enabled';

    public const CHANNELS_COLUMN = 'channels';

    public const COLLECTIONS_COLUMN = 'collections';

    public const SLUG_COLUMN = 'slug__locale__';

    public const META_TITLE_COLUMN = 'meta_title__locale__';

    public const META_KEYWORDS_COLUMN = 'meta_keywords__locale__';

    public const META_DESCRIPTION_COLUMN = 'meta_description__locale__';
}
