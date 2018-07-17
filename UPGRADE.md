# UPGRADE FROM 1.0 TO 2.0

* With CMS 2.0, Sylius 1.2 is required
* A lot of database modifications has been made. Read the below changelog first and then migrate your
structure using `bin/console doctrine:migrations:diff && bin/console doctrine:migrations:migrate` commands
* Media type field has been removed. For image blocks, use the [media](doc/medias.md) with image type. For HTML blocks,
use raw content in [WYSIWYG editor](doc/wysiwyg.md)
* Chanel awareness has been added to pages, blocks, FAQs, sections and media. That being said, many
repository methods changed their signatures. In case you customized them in your src, check 
new signatures in interfaces under [BitBag\SyliusCmsPlugin\Repository](src/Repository) namespace
* WYSIWYG editor has been introduced. You will need to import it in your AppKernel and install 
its assets. For more, check the [installation guide](doc/installation.md)
* Sitemap support was added, you will need to enable extra bundle in your AppKernel. Read more
in the [sitemap documentation](doc/sitemap.md)
* Because of the possibility to [nest CMS Twig functions in the admin backend](doc/twig-functions-in-admin.md), in order to render block and page content
you are now supposed to use `bitbag_cms_render_content` Twig function

# UPGRADE FROM 1.2.1/1.1.1 to 1.2.2

* `bitbag_render_block` has been renamed to `bitbag_cms_render_block`.
* Database tables has been prefixed with `bitbag_cms` instead of `bitbag_sylius_cms_plugin` for backward compatibility and simplicity.
* `ImageBlockUploadListener` has been renamed to `BlockImageUploadListener`
* Resources has been moved from `sylius_resource` to `resources` directory
* Doctrine models has been marked as `mappedSuperclass` instead of `entity`

# UPGRADE FROM 1.0.0 to 1.1.0/1.2.0 and from 1.1.0/1.2.0 to 1.2.1

* Generate Doctrine diff with `bin/console doctrine:migrations:diff` command, add a simple SQL insert that moves 
the data from the old table and inserts it to the new one. After it's done, it would be nice to drop the old tables 
in your database, so you will keep your environment clean.
* `bitbag_render_page_link_by_code` has been removed, use `bitbag_sylius_cms_plugin_shop_page_show_link_by_code` controller route instead. See README.md for more info.
