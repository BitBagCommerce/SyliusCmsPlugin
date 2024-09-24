<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Importer\Legacy;

use Sylius\CmsPlugin\Importer\ImporterInterface;

interface LegacyPageImporterInterface extends ImporterInterface
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

    public const NAME_WHEN_LINKED_COLUMN = 'name_when_linked__locale__';

    public const DESCRIPTION_WHEN_LINKED_COLUMN = 'description_when_linked__locale__';
}
