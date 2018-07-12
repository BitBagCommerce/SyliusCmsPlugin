# Importing resources

This plugin enables you to import resources from CSV files in the admin panel or a command. Each resource that has
the import feature has its own unique code recognized by [ImporterChain](src/Importer/ImporterChain.php).

The importer architecture uses specially tagged services to evaluate a specific resource import process.

## List of currently working importers:


| Resource code | Importer                                                  |
|---------------|-----------------------------------------------------------|
| block         | [BlockImporter](src/Importer/BlockImporter.php)           |
| page          | [PageImporter](src/Importer/PageImporter.php)             |
| media         | [MediaImporter](src/Importer/MediaImporter.php)           |


## CSV file format

Currently implemented importers support following column names, which are constants values from below table.

*Note:* 
- `__locale__` suffix needs to be replaced with a specific locale configured in your admin panel.
- `sections`, `channels` and `products` represent associations that are recognized with comma separated resource codes.
For instance, if you want to associate three sections via the CSV file, you should fill the `sections` column with 
`homepage, blog, delivery` value, where each value is single section code.

| Resource code | Importer columns interface                                         |
|---------------|--------------------------------------------------------------------|
| block         | [BlockImporterInterface](src/Importer/BlockImporterInterface.php)  |
| page          | [PageImporterInterface](src/Importer/PageImporterInterface.php)    |
| media         | [MediaImporterInderface](src/Importer/MediaImporterInterface.php)  |
