# Importing resources

This plugin enables you to import resources from CSV files in the admin panel or a command. Each resource that has
the import feature has its own unique code recognized by [ImporterChain](../src/Importer/ImporterChain.php).

The importer architecture uses specially tagged services to evaluate a specific resource import process. All default importers
are validated against constraints used in the admin panel. What's more, thanks to 
[ResourceResolver](../src/Resolver/ResourceResolver.php) service, you can both create and update resources.  

## List of currently working importers

| Resource code | Importer                                                  |
|---------------|-----------------------------------------------------------|
| block         | [BlockImporter](../src/Importer/BlockImporter.php)           |
| page          | [PageImporter](../src/Importer/PageImporter.php)             |
| media         | [MediaImporter](../src/Importer/MediaImporter.php)           |


## CSV file format

Currently implemented importers support following column names, which are constants values from below table.

**Note:**
- `collections`, `channels`, `locales`, `products`, `products_in_taxons`, `taxons` represent associations that are recognized with comma separated resource codes.
For instance, if you want to associate three collections via the CSV file, you should fill the `collections` column with 
`homepage, blog, delivery` value, where each value is a single collection code.

| Resource code | Importer columns interface                                         |
|---------------|--------------------------------------------------------------------|
| block         | [BlockImporterInterface](../src/Importer/BlockImporterInterface.php)  |
| page          | [PageImporterInterface](../src/Importer/PageImporterInterface.php)    |
| media         | [MediaImporterInterface](../src/Importer/MediaImporterInterface.php)  |

## Importing via command

As previously mentioned, in order to import a data, you need to pick specific resource importer via the resource code.

In order to import data via command, execute:

```bash
$ bin/console bitbag:import:csv [resource code] [path/to/your/csv/file.csv]
```

For instance, if you wish to import a page, run:

```bash
$ bin/console bitbag:import:csv page ~/Documents/pages.csv
```

## Importing via admin panel

**Note:**

*Make sure you installed assets from the [installation guide](../README.md).  We use some custom assets in 
our CMS pages in admin panel that are required in order to use the plugin features properly.*

You should see an import button near create action. Just click it, select a proper CSV file and push import button.

## Adding custom importer

1. In order to add an importer, you need to declare a resource resolver first, that will be needed to determine whether
the resolver needs to create a new resource or update an existing one:

```yaml
    app.resolver.resource.product:
        class: Sylius\CmsPlugin\Resolver\ResourceResolver
        arguments:
            - "@sylius.repository.product"
            - "@sylius.factory.product"
            - "code" # this parameter points to an unique field that the findOneBy method will be looking for. It could be id as well
``` 

2. Then, create an importer interface, that will contain column names as constants:

```php
<?php

declare(strict_types=1);

namespace AppBundle\Importer;

use  Sylius\CmsPlugin\Importer\ImporterInterface;

interface ProductImporterInterface extends ImporterInterface
{
    const CODE_COLUMN = 'code';
    const NAME_COLUMN = 'name__locale__';
    const DESCRIPTION_COLUMN = 'description__locale__';
    const SLUG_COLUMN = 'slug__locale__';
}
```

3. Finally, declare an importer class:

```php
<?php

declare(strict_types=1);

namespace AppBundle\Importer;

use Sylius\CmsPlugin\Importer\AbstractImporter;
use Sylius\CmsPlugin\Resolver\ResourceResolverInterface;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ProductImporter extends AbstractImporter implements ProductImporterInterface
{
    /** @var ResourceResolverInterface */
    private $mediaResourceResolver;

    /** @var LocaleContextInterface */
    private $localeContext;

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(
        ResourceResolverInterface $mediaResourceResolver,
        LocaleContextInterface $localeContext,
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager
    ) {
        parent::__construct($validator);

        $this->mediaResourceResolver = $mediaResourceResolver;
        $this->localeContext = $localeContext;
        $this->entityManager = $entityManager;
    }

    public function import(array $row): void
    {
        $code = $this->getColumnValue(self::CODE_COLUMN, $row);
        $media = $this->mediaResourceResolver->getResource($code);

        $media->setCode($code);
        $media->setFallbackLocale($this->localeContext->getLocaleCode());

        foreach ($this->getAvailableLocales($this->getTranslatableColumns(), array_keys($row)) as $locale) {
            $media->setCurrentLocale($locale);
            $media->setName($this->getTranslatableColumnValue(self::NAME_COLUMN, $locale, $row));
            $media->setDescription($this->getTranslatableColumnValue(self::DESCRIPTION_COLUMN, $locale, $row));
            $media->setSlug($this->getTranslatableColumnValue(self::SLUG_COLUMN, $locale, $row));
        }

        // below method will throw an error in case the validation fails, which will be displayed in the admin panel or console
        // the second parameter is a validation groups array
        $this->validateResource($media, ['app']);

        $media->getId() ?: $this->entityManager->persist($media);
        $this->entityManager->flush();
    }

    public function getResourceCode(): string
    {
        return 'product';
    }

    // list of translatable columns (the ones with __locale__ suffix)
    private function getTranslatableColumns(): array
    {
        return [
            self::NAME_COLUMN,
            self::DESCRIPTION_COLUMN,
            self::SLUG_COLUMN,
        ];
    }
}
```

4. Last, but not least, register the importer as a service:

```yaml
    app.importer.product:
        class: AppBundle\Importer\ProductImporter
        arguments:
            - "@app.resolver.resource.product"
            - "@sylius.context.locale"
            - "@validator"
            - "@doctrine.orm.entity_manager"
        tags:
            - { name: bitbag.cmsplugin.importer }
```

5. :tada:

Now you can use the `$ bin/console bitbag:import:csv product /path/to/products.csv/file` command to upload your products.

Read the below section to enable the import from UI feature.

## Using grid action for a newly created importer

```yaml
sylius_grid:
    grids:
        sylius_admin_product:
            actions:
                main:
                
                    # ...default actions
                    #
                    # If you decide to override the admin products importer, 
                    # you need to copy all default actions, as this config 
                    # will be overridden :)
                    
                    import:
                        type: import
                        options:
                            resourceCode: product
```

### Overriding the importer grid template

Create an `_importForm.html.twig` file under `app/Resources/BitBagSyliusCmsPlugin/views/Grid/Form` location. Take a look at
the default [_importForm.html.twig](../src/Resources/views/Grid/Form/_importForm.html.twig) file.

### Example

Take a look at [block.csv](block.csv) file as an example. CSV files for another resources should not differ much from it.
