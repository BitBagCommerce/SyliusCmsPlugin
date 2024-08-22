# UPGRADE FROM 4.2 TO 5.0

This upgrade is a major one, as it introduces a new feature - [Content Elements](doc/content_elements.md)
and removes the old way of creating blocks and pages.

* A lot of database modifications has been made. Read the below changelog first and then migrate your structure using
  `bin/console doctrine:migrations:diff && bin/console doctrine:migrations:migrate` commands.
* Sections are now Collections, as it was a more suitable name for the feature.
* Pages and Blocks now have `Content elements` segment, where you can add elements to the page or block.
* Removed FAQ, as you can now create a FAQ page with the new content elements.
* Added new `Templates` section where you can create templates for your content elements. Read more about it in [Use case templates](doc/use_case_templates.md)
and [Templates](doc/templates.md) docs.
* Removed CKEditor deprecation modal.
* Reordered forms/elements for functionality consistency.
* Updated import functionality to work with the new structure.
* Updated fixtures to work with the new structure
* Removed `bitbag_cms_render_product_pages` twig extension.
* Removed support for rendering twig functions in WYSIWYG editor.
* Added twig extensions: 
  * `bitbag_cms_render_collection`
  * `bitbag_cms_render_content_elements`

## Briefly about Content Elements

Content elements is a new segment in the block/page form where you can add elements that will be rendered on the store's frontend, like:
* Textarea
* Heading
* Images
* Products carousel
* etc.

> Read more about the content elements in the updated [Content elements](doc/content_elements.md) doc.

## Changes in Collections (old Sections)

### Added fields:

* Type
* Pages/Block/Media (depending on the chosen type)

### Moved fields:

* Name field has been moved from translations to the main settings tab

> Read more about the collections in the updated [Use case collections](doc/use_case_collections.md) and [Collections](doc/collections.md) docs.

## Changes in Pages

### Removed fields:

* Products
* Breadcrumb
* Name when linked
* Description when linked
* Image
* Content
* Title

### Added fields

* Teaser title
* Teaser content
* Teaser image

### Moved fields

* Name field has been moved from translations to the main settings tab

> Read more about the pages in the updated [Use case pages](doc/use_case_pages.md) and [Pages](doc/pages.md) docs.

## Changes in Blocks

### Removed fields:

* Products
* Taxons
* Whole translations tab

### Added fields

* Name
* Locales
* Display for products
* Display for products in taxons
* Display for taxons

> Read more about the blocks in the updated [Use case blocks](doc/use_case_blocks.md) and [Blocks](doc/blocks.md) docs.

## Changes in Media

### Removed fields:

* Products

### Added fields

* Media preview with path

### Moved fields

* Name field has been moved from translations to the main settings tab

### Renamed fields

* Content -> Link content
