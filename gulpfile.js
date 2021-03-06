var elixir = require('laravel-elixir');

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

elixir(function(mix) {
    mix.sass('app.scss')
        .copy('node_modules/bootstrap-colorpicker/dist/img', 'public/img')
        .styles([
            '../public/css/app.css',
            'bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css',
        ], 'public/css/app.css', 'node_modules')
        .copy('node_modules/bootstrap-sass/assets/fonts', 'public/fonts')
        .scripts([
        'jquery/dist/jquery.min.js',
        'bootstrap-sass/assets/javascripts/bootstrap.min.js',
        'bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js',
    ], 'public/js/all.js', 'node_modules')
        .scripts([
        'functions.js',
        'system.js'
    ], 'public/js/app.js');
});
