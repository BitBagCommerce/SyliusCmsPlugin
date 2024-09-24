<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Importer\Legacy;

use Sylius\CmsPlugin\Importer\ImporterInterface;

interface LegacyBlockImporterInterface extends ImporterInterface
{
    public const CODE_COLUMN = 'code';

    public const SECTIONS_COLUMN = 'sections';

    public const CHANNELS_COLUMN = 'channels';

    public const PRODUCTS_COLUMN = 'products';

    public const NAME_COLUMN = 'name__locale__';

    public const CONTENT_COLUMN = 'content__locale__';

    public const IMAGE_COLUMN = 'image__locale__';
}
