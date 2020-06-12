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

// mix.babelConfig({
//     // "presets": [["@babel/env", { "modules": "commonjs" }]],
//     "plugins": ["add-module-exports"]
// });

module.exports = {
    module: {
        rules: [
            {
                test: /\.s[ac]ss$/i,
                use: [
                    // Creates `style` nodes from JS strings
                    'style-loader',
                    // Translates CSS into CommonJS
                    'css-loader',
                    // Compiles Sass to CSS
                    'sass-loader',
                ],
            },
        ],
    },
};

mix.webpackConfig({
    output: {
        chunkFilename: 'js/chunks/[name].js',
        publicPath: '/'
    }
});

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/dark_app.scss', 'public/css')
   .sass('resources/sass/app.scss', 'public/css')

if(mix.inProduction()){
    mix.version();
}

mix.sass('node_modules/cropperjs/src/css/cropper.scss', 'public/css');
