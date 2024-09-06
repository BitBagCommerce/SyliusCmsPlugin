<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Importer;

interface BlockImporterInterface extends ImporterInterface
{
    public const CODE_COLUMN = 'code';

    public const NAME_COLUMN = 'name';

    public const ENABLED_COLUMN = 'enabled';

    public const COLLECTIONS_COLUMN = 'collections';

    public const LOCALES_COLUMN = 'locales';

    public const CHANNELS_COLUMN = 'channels';

    public const PRODUCTS_COLUMN = 'products';

    public const PRODUCTS_IN_TAXONS_COLUMN = 'products_in_taxons';

    public const TAXONS_COLUMN = 'taxons';
}
