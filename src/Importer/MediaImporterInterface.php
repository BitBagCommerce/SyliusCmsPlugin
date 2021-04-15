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

interface MediaImporterInterface extends ImporterInterface
{
    public const CODE_COLUMN = 'code';

    public const TYPE_COLUMN = 'type';

    public const SECTIONS_COLUMN = 'sections';

    public const CHANNELS_COLUMN = 'channels';

    public const PRODUCTS_COLUMN = 'products';

    public const NAME_COLUMN = 'name__locale__';

    public const CONTENT_COLUMN = 'content__locale__';

    public const ALT_COLUMN = 'alt__locale__';
}
