const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js([ //plugins y archivos globales
    'resources/js/app.js',
    'resources/js/plugins/jquery.notifyBar.js'
], 'public/js')
.js('resources/js/products.js', 'public/js') //archivos por modulos
// .js('resources/js/sales.js', 'public/js')
.js('resources/js/sales-angular.js', 'public/js')
.js('resources/js/providers.js', 'public/js')
.js('resources/js/login.js', 'public/js')
.js('resources/js/users.js', 'public/js')
.postCss('resources/css/app.css', 'public/css', [
    require('postcss-import'),
    require('tailwindcss'),
    require('autoprefixer'),
])
.postCss('resources/css/plugins/jquery-ui.css', 'public/css/plugins')
.postCss('resources/css/plugins/notifyBar.css', 'public/css/plugins')
.copy('resources/css/plugins/jq-notify-bar-icons.svg', 'public/css/plugins');
