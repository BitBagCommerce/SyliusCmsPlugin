const path = require('path');
const Encore = require('@symfony/webpack-encore');
const pluginName = 'cms';

const getConfig = (pluginName, type) => {
    Encore.reset();

    Encore.setOutputPath(`public/build/${pluginName}/${type}/`)
        .setPublicPath(`/build/${pluginName}/${type}/`)
        .addEntry(`sylius-${pluginName}-${type}`, path.resolve(__dirname, `./src/Resources/assets/${type}/entry.js`))
        .disableSingleRuntimeChunk()
        .cleanupOutputBeforeBuild()
        .enableSourceMaps(!Encore.isProduction())
        .enableSassLoader();

    const config = Encore.getWebpackConfig();
    config.name = `sylius-${pluginName}-${type}`;

    return config;
};

Encore.setOutputPath(`src/Resources/public/build/`)
    .setPublicPath(`/public/build/`)
    .addEntry(`sylius-${pluginName}-shop`, path.resolve(__dirname, `./src/Resources/assets/shop/entry.js`))
    .addEntry(`sylius-${pluginName}-admin`, path.resolve(__dirname, `./src/Resources/assets/admin/entry.js`))
    .cleanupOutputBeforeBuild()
    .disableSingleRuntimeChunk()
    .enableSassLoader();

const distConfig = Encore.getWebpackConfig();
distConfig.name = `cms-plugin-dist`;

Encore.reset();

const shopConfig = getConfig(pluginName, 'shop');
const adminConfig = getConfig(pluginName, 'admin');

module.exports = [shopConfig, adminConfig, distConfig];
