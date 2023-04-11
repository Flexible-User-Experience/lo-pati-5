const Encore = require('@symfony/webpack-encore');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory copy
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .copyFiles([
        {from: './assets/fonts', to: 'fonts/[path][name].[ext]'},
        {from: './assets/images', to: 'images/[path][name].[ext]'},
        {from: './assets/vectors', to: 'vectors/[path][name].[ext]'},
    ])
    // entries
    .addEntry('frontend', './assets/frontend.js')
    .addEntry('backend', './assets/backend.js')
    .addEntry('mail', './assets/mail.js')
    // config
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = '3.23';
    })
    // features
    .cleanupOutputBeforeBuild()
    .splitEntryChunks()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .enableStimulusBridge('./assets/controllers.json')
    .enableSingleRuntimeChunk()
    .enableSassLoader()
;

module.exports = Encore.getWebpackConfig();
