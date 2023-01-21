const mix = require('laravel-mix');
// mix.setResourceRoot('../');
const path = require('path');
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.webpackConfig({
    resolve: {
        alias: {
            '@components': path.resolve(__dirname, 'resources/js/components'),
            '@pages': path.resolve(__dirname, 'resources/js/pages'),
            '@themes': path.resolve(__dirname, 'resources/js/themes'),
            '@modal-admin': path.resolve(__dirname, 'resources/js/components/Modal/Admin'),
            '@modal-admin-form': path.resolve(__dirname, 'resources/js/components/Modal/Admin/Form'),
            '@modal-admin-area': path.resolve(__dirname, 'resources/js/components/Modal/Admin/Area'),
            '@modal-admin-button': path.resolve(__dirname, 'resources/js/components/Modal/Admin/Button'),
            '@admin-item': path.resolve(__dirname, 'resources/js/components/Admin/Items'),
        }
    },
});

//.LICENSE filesを抽出しない為、falseを設定する
mix.options({
    terser: {
        extractComments: false,
    }
})

mix.js('resources/js/app.js', 'public/assets/js')
    .postCss('resources/css/app.css', 'public/assets/css', [])
    .vue({ version: 3 })
    .sourceMaps();
