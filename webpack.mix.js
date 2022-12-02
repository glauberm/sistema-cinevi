const mix = require('laravel-mix');

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

mix.setPublicPath('public_html/');

mix.sass('resources/styles/index.scss', 'css').version();

mix.js('resources/scripts/index.js', 'js').version();

mix.copy('resources/fonts/GillSansNova-Bold.woff2', 'public_html/fonts/GillSansNova-Bold.woff2')
    .copy('resources/fonts/GillSansNova-Medium.woff2', 'public_html/fonts/GillSansNova-Medium.woff2')
    .version();

mix.copy('resources/images/favicon.ico', 'public_html/favicon.ico')
    .copy('resources/images/favicon.svg', 'public_html/images/favicon.svg')
    .copy('resources/images/favicon.png', 'public_html/images/favicon.png')
    .version();
