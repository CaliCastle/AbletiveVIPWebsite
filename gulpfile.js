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
    mix.sass('app.scss');

    // App
    mix.styles([
        'normalize.css',
        'app.css',
        'sweetalert.css',
    ], null, 'public/css');

    // Manage page css
    //mix.styles([
    //    'normalize.css',
    //    'manage.css',
    //    'sweetalert.css',
    //], 'public/css/manage.css', 'public/css');

    // App
    mix.scripts([
        'jquery.min.js',
        'classie.js',
        'notificationFx.js',
        'sweetalert.min.js',
        'isotope.pkgd.min.js',
        'flickity.pkgd.min.js',
        //'main.js'
    ]);

    // Manage page js
    //mix.scripts([
    //    'jquery.min.js',
    //    'classie.js',
    //    'notificationFx.js',
    //    'sweetalert.min.js',
    //], 'public/js/manage.js');

    mix.version([
        'css/all.css',
        //'css/manage.css',
        'js/all.js'
        //'js/manage.js'
    ])
});
