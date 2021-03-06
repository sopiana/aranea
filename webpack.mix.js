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

mix.js('resources/js/main.js', 'public/assets/js/main.js')
    .styles([
        'node_modules/simple-line-icons/css/simple-line-icons.css',
        'node_modules/font-awesome/css/font-awesome.css',
        'node_modules/datatables.net-dt/css/jquery.dataTables.css',
        'node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css',
        'node_modules/quill/dist/quill.core.css',
        'node_modules/quill/dist/quill.bubble.css',
        'resources/css/main.css'],
            'public/assets/css/main.css')
    .copy(['resources/assets'],'public/assets')
    .copy(['node_modules/simple-line-icons/fonts',
        'node_modules/font-awesome/fonts'],'public/assets/fonts');
