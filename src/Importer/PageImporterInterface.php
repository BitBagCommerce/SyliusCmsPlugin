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

    public const NAME_COLUMN = 'name';

    public const ENABLED_COLUMN = 'enabled';

    public const CHANNELS_COLUMN = 'channels';

    public const COLLECTIONS_COLUMN = 'collections';

    public const SLUG_COLUMN = 'slug__locale__';

    public const META_TITLE_COLUMN = 'meta_title__locale__';

    public const META_KEYWORDS_COLUMN = 'meta_keywords__locale__';

    public const META_DESCRIPTION_COLUMN = 'meta_description__locale__';
}
