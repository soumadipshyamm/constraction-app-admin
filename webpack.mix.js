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

/* mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sourceMaps();
 */

mix.webpackConfig({
    devtool: 'inline-source-map'
});
mix.copyDirectory('resources/assets', 'public/assets');
mix.copyDirectory('resources/frontend_assets', 'public/frontend_assets');
mix.copyDirectory('resources/company_assets', 'public/company_assets');
