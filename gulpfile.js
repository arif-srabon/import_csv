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
    mix.sass(
    	'app.scss',
    	'public/assets/css/app.css' //output file
    );

    /**
     * Combining files
     * - Bootstrap.js v3.3.7
     * - iNewsTicker v0.1.0
     * - jQuery MatchHeight v0.7.0
     * - Site.js v1.0.0 (ADR_DGDA)
     *
     * into
     * - Main.js v1.0.0
     */
    mix.scripts(
	    ['bootstrap.js', 'inewsticker.js', 'jquery.matchHeight-min.js', 'site.js'],
	    'public/assets/js/main.js' //output file
	);
});
