# UPGRADE FROM `v4.3` TO `v4.4`

This update adds support for Trix (as an optional WYSIWYG editor). If you would like to replace CKeditor with Trix review the plugin installation steps.

The configuration has been split and the `fos_ck_editor` configuration is required to be added with this update.

1. Import required CKeditor config in your `config/packages/_sylius.yaml` file:
```yaml
# config/packages/_sylius.yaml

imports:
    ...
    
    - { resource: "@BitBagSyliusCmsPlugin/Resources/config/fos_ck_editor/fos_ck_editor.yml" }
```

*Or copy contents of `vendor/BitBag/cms-plugin/src/Resources/config/fos_ck_editor/fos_ck_editor.yml` to `config/packages/fos_ck_editor.yaml` file.*

2. If project use a `./vendor/bitbag/cms-plugin/webpack.config.js` file in `webpack.config.js` you need change:

From:
```js
// webpack.config.js

const [ bitbagCmsShop, bitbagCmsAdmin ] = require('./vendor/bitbag/cms-plugin/webpack.config.js')

...

module.exports = [..., bitbagCmsShop, bitbagCmsAdmin];
```

To:
```js
// webpack.config.js

const createCmsConfigs  = require('./vendor/bitbag/cms-plugin/webpack.config.js');

...

const [bitbagCmsShop, bitbagCmsAdmin] = createCmsConfigs({
    wysiwyg: 'ckeditor' // 'ckeditor' | 'trix'
});

module.exports = [..., bitbagCmsShop, bitbagCmsAdmin];
```
