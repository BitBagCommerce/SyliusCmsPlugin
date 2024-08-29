<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Importer;

use Sylius\Component\Resource\Model\ResourceInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractImporter implements ImporterInterface
{
    public function __construct(private ValidatorInterface $validator)
    {
    }

    public function cleanup(): void
    {
    }

    protected function getColumnValue(string $column, array $row)
    {
        return $row[$column] ?? null;
    }

    protected function getTranslatableColumnValue(
        string $column,
        $locale,
        array $row,
    ) {
        $column = str_replace('__locale__', '_' . $locale, $column);

        return $row[$column] ?? null;
    }

    protected function getAvailableLocales(array $translatableColumns, array $columns): array
    {
        $locales = [];

        foreach ($translatableColumns as $translatableColumn) {
            $translatableColumn = str_replace('__locale__', '_', $translatableColumn);

            foreach ($columns as $column) {
                if (str_starts_with($column, $translatableColumn)) {
                    $locales[] = str_replace($translatableColumn, '', $column);
                }
            }
        }

        return array_unique($locales);
    }

    protected function validateResource(ResourceInterface $resource, array $groups): void
    {
        $errors = $this->validator->validate($resource, null, $groups);

        if (0 < count($errors)) {
            $message = '';

            foreach ($errors as $error) {
                $message .= lcfirst(rtrim($error->getMessage(), '.')) . ', ';
            }

            $message = ucfirst(rtrim($message, ', ')) . '.';

            throw new \RuntimeException($message);
        }
    }
}
