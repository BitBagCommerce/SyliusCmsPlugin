# Importing resources

This plugin enables you to import resources from CSV files in the admin panel or a command. Each resource that has
the import feature has its own unique code recognized by [ImporterChain](src/Importer/ImporterChain.php).

The importer architecture uses specially tagged services to evaluate a specific resource import process. All default importers
are validated against constraints used in the admin panel. What's more, thanks to 
[ResourceResolver](src/Resolver/ResourceResolver.php) service, you can both create and update resources.  

## List of currently working importers:

| Resource code | Importer                                                  |
|---------------|-----------------------------------------------------------|
| block         | [BlockImporter](src/Importer/BlockImporter.php)           |
| page          | [PageImporter](src/Importer/PageImporter.php)             |
| media         | [MediaImporter](src/Importer/MediaImporter.php)           |


## CSV file format

Currently implemented importers support following column names, which are constants values from below table.

**Note:**
- `__locale__` suffix needs to be replaced with a specific locale configured in your admin panel.
- `sections`, `channels` and `products` represent associations that are recognized with comma separated resource codes.
For instance, if you want to associate three sections via the CSV file, you should fill the `sections` column with 
`homepage, blog, delivery` value, where each value is a single section code.

| Resource code | Importer columns interface                                         |
|---------------|--------------------------------------------------------------------|
| block         | [BlockImporterInterface](src/Importer/BlockImporterInterface.php)  |
| page          | [PageImporterInterface](src/Importer/PageImporterInterface.php)    |
| media         | [MediaImporterInterface](src/Importer/MediaImporterInterface.php)  |

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
