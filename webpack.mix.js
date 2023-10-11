const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sasss
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .copy('resources/js/login.js','public/js')
    .copy('resources/js/register.js','public/js')
    .copy('resources/js/recover-password.js','public/js')
    .copy('resources/js/templates-datatable.js','public/js')
    .copy('resources/js/reset-password.js','public/js');
