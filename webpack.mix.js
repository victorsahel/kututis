const mix = require('laravel-mix');
require('laravel-mix-bundle-analyzer');

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

if (!mix.inProduction()) {
    mix.bundleAnalyzer();
}

mix.js('resources/js/kututis.js', 'public/js')
    .sass('resources/sass/kututis.scss', 'public/css')
    .options({
        processCssUrls: false
    })
    .sourceMaps();

