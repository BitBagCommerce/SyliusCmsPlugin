# UPGRADE FROM 1.2.1/1.1.1 to 1.2.2-dev

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
