# UPGRADE FROM 1.0.0 to 1.1.0 and from 1.1.0 to 1.2.0

* Generate Doctrine diff with `bin/console doctrine:migrations:diff` command, add a simple SQL insert that moves 
the data from the old table and inserts it to the new one. After it's done, it would be nice to drop the old tables 
in your database, so you will keep your environment clean.
* `bitbag_render_page_link_by_code` has been removed, use `bitbag_sylius_cms_plugin_shop_page_show_link_by_code` instead. See README.md for more info
