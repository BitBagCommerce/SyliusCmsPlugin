# UPGRADE FROM `v4.3` TO `v4.4`

This update adds support for Trix (as an optional WYSIWYG editor). If you would like to replace CKeditor with Trix review the plugin installation steps.

Therefore, the configuration has been split and the `fos_ck_editor` configuration is required to be added with this update.

Import required CKeditor config in your `config/packages/_sylius.yaml` file:
```yaml
# config/packages/_sylius.yaml

imports:
    ...
    
    - { resource: "@BitBagSyliusCmsPlugin/Resources/config/fos_ck_editor/fos_ck_editor.yml" }
```

Or copy contents of `vendor/BitBag/cms-plugin/src/Resources/config/fos_ck_editor/fos_ck_editor.yml` to `config/packages/fos_ck_editor.yaml` file.
