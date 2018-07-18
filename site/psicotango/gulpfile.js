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


//we need to put all CSS and JS files in the correct path and then run gulp
//or gulp --production and will minify it

elixir((mix) => {
    mix.webpack('app.js');

    mix.scripts([
        //'vendor/vue.min.js',
        //'vendor/vue-resource.min.js',
    
        //'./node_modules/jquery/dist/jquery.min.js',
        'vendor/jquery.js',
        'vendor/hover3d.js',
        'vendor/jquery.gmap.js',
        'vendor/plugins.js',
        'vendor/functions.js',
        'psicotango.js',
    ], 'public/js/vendor.js');

    mix.styles([
        'bootstrap.css',
        'style.css',
        'colors.css',
        'swiper.css',
        'dark.css',
        'font-icons.css',
        'animate.css',
        'magnific-popup.css',
        'writer.css',
        'responsive.css'
    ], 'public/css/vendor.css');
});
