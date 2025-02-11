const path = require('path');
const Encore = require('@symfony/webpack-encore');
const pluginName = 'cms';

const getConfig = (pluginName, type) => {
    Encore.reset();

    Encore.setOutputPath(`public/build/bitbag/${pluginName}/${type}/`)
        .setPublicPath(`/build/bitbag/${pluginName}/${type}/`)
        .addEntry(`bitbag-${pluginName}-${type}`, path.resolve(__dirname, `./src/Resources/assets/${type}/entry.js`))
        .disableSingleRuntimeChunk()
        .cleanupOutputBeforeBuild()
        .enableSourceMaps(!Encore.isProduction())
        .enableSassLoader();

    const config = Encore.getWebpackConfig();
    config.name = `bitbag-${pluginName}-${type}`;

    return config;
};

Encore.setOutputPath(`src/Resources/public/build/`)
    .setPublicPath(`/public/build/`)
    .addEntry(`bitbag-${pluginName}-shop`, path.resolve(__dirname, `./src/Resources/assets/shop/entry.js`))
    // Ckeditor
    .addEntry(`bitbag-${pluginName}-admin`, path.resolve(__dirname, `./src/Resources/assets/admin/entry.js`))
    // Trix
    // .addEntry(`bitbag-${pluginName}-admin`, path.resolve(__dirname, `./src/Resources/assets/admin/trix-entry.js`))
    .cleanupOutputBeforeBuild()
    .disableSingleRuntimeChunk()
    .enableSassLoader();

const distConfig = Encore.getWebpackConfig();
distConfig.name = `bitbag-plugin-dist`;

Encore.reset();

const shopConfig = getConfig(pluginName, 'shop');
const adminConfig = getConfig(pluginName, 'admin');

module.exports = [shopConfig, adminConfig, distConfig];
