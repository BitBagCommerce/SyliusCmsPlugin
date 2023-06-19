<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Importer;

use Sylius\Component\Resource\Model\ResourceInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractImporter implements ImporterInterface
{
    /** @var ValidatorInterface */
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

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

    protected function getTranslatableColumnValue(
        string $column,
        $locale,
        array $row,
    ) {
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
