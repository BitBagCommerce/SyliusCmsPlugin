# Legacy data migration

## Introduction

You can migrate your blocks & pages from the 4.x version to the 5.x version of the plugin.
To do so, you need to follow the steps below.

## Steps

1. Create new CSV files with blocks & pages data in the 4.x format.  
See an example in [block_legacy.csv](block_legacy.csv) or [page_legacy.csv](page_legacy.csv).
2. Install the 5.x version of the plugin.
3. Go to the console and run the following command:
```bash
bin/console cms:import:csv page_legacy {file_path}.csv
bin/console cms:import:csv block_legacy {file_path}.csv
```

## Info about legacy CSV files columns

### Blocks

- **code** - block code.
- **type** - it will be ignored.
- **name_LOCALE** - block name. First occurrence of its column is the default name for the block. 
For each locale, there will be created a Heading content element.
- **content_LOCALE** - block content. For each locale, there will be created a Textarea content element.
- **sections** - it will be converted to the block's collections.
- **channels** - block channels.
- **products** - block products. There will be created Products grid content element.
- **image_LOCALE** - block image. For each locale, there will be created a Single media content element.
- **slug_LOCALE** - it will be ignored.

### Pages

- **code** - page code.
- **sections** - it will be converted to the page's collections.
- **channels** - page channels.
- **products** - page products. There will be created Products grid content element.
- **slug_LOCALE** - page slug.
- **name_LOCALE** - page name. First occurrence of its column is the default name for the page.
For each locale, there will be created a Heading content element.
- **image_LOCALE** - page image. For each locale, there will be created a Single media content element.
- **meta_keywords_LOCALE** - page meta keywords.
- **meta_description_LOCALE** - page meta description.
- **content_LOCALE** - page content. For each locale, there will be created a Textarea content element.
- **breadcrumb_LOCALE** - it will be ignored.
- **name_when_linked_LOCALE** - for each locale, there will be created a teaser title.
- **description_when_linked_LOCALE** - for each locale, there will be created a teaser content.
