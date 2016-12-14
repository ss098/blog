const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application as well as publishing vendor resources.
 |
 */

elixir.config.sourcemaps = false;

elixir((mix) => {
    mix.sass('app.scss')
        .webpack('app.js')
        .copy("resources/assets/js/promise.min.js", "public/js/promise.min.js")
        //.copy("resources/assets/image", "public/image")
        //.version(['css/app.css', 'js/app.js']);
});
