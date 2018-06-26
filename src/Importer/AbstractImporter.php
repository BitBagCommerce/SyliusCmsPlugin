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

abstract class AbstractImporter implements ImporterInterface
{
    public function cleanup(): void
    {
    }

    protected function getColumnValue(string $column, array $row)
    {
        if (array_key_exists($column, $row)) {
            return $row[$column];
        }

        return null;
    }

    protected function getTranslatableColumnValue(string $column, $locale, array $row)
    {
        $column = str_replace('__locale__', '_' . $locale, $column);

        if (array_key_exists($column, $row)) {
            return $row[$column];
        }

        return null;
    }

    protected function getAvailableLocales(array $translatableColumns, array $columns): array
    {
        $locales = [];

        foreach ($translatableColumns as $translatableColumn) {
            $translatableColumn = str_replace('__locale__', '_', $translatableColumn);

            foreach ($columns as $column) {
                if (0 === strpos($column, $translatableColumn)) {
                    $locales[] = str_replace($translatableColumn, '', $column);
                }
            }
        }

        return array_unique($locales);
    }
}
