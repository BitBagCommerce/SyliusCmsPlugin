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

interface BlockImporterInterface extends ImporterInterface
{
    const CODE_COLUMN = 'code';
    const TYPE_COLUMN = 'type';
    const NAME_COLUMN = 'name';
    const IMAGE_COLUMN = 'image';
    const SECTION_COLUMN = 'section';
    const LINK_COLUMN = 'link';
    const CONTENT_COLUMN = 'content';
}
