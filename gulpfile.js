const elixir = require('laravel-elixir');

require('laravel-elixir-vue');
require('laravel-elixir-vueify');
require('laravel-elixir-browserify-official');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(mix => {
    mix
        .copy([
            './node_modules/bootstrap-sass/assets/fonts/**',
            './node_modules/font-awesome/fonts/**'
        ], 'public/build/fonts')

        .sass('app.scss')

        .less('app.less', 'public/css/timepicker.css')

        .browserify('app.js')
        .scripts(['custom.js'], 'public/js/custom.js')
        .version(['css/app.css', 'js/app.js']);
});
