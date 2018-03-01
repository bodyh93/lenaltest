let mix = require('laravel-mix');

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
 mix.js('resources/assets/js/app.js', 'public/js')
     .sass('resources/assets/sass/app.scss', 'public/css')
     .styles([
         'resources/assets/css/fontawesome-all.min.css',
         'resources/assets/css/custom.css'
     ], 'public/css/other.css')
     .scripts([
         'resources/assets/js/jquery.min.js',
         'resources/assets/js/custom.js'
     ], 'public/js/other.js');