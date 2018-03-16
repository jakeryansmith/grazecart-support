let mix = require('laravel-mix');

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


mix.js('resources/assets/js/app.js', 'js');

mix.js('resources/assets/js/marketing.js', 'js');

mix.less('resources/assets/less/marketing.less', '../resources/css');


mix.styles(
	[
		'resources/css/graze.css',
        'resources/css/marketing.css'
	], 'public/css/styles.css');

mix.version();

mix.browserSync({
    proxy: 'grazesupport.test'
});
