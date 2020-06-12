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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/dark_app.scss', 'public/css')
   .sass('resources/sass/app.scss', 'public/css');

// mix.minify('public/js/app.js');

if(mix.inProduction()){
    mix.version();
}

mix.sass('node_modules/cropperjs/src/css/cropper.scss', 'public/css');
