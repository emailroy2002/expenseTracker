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

 /*
mix.scripts([
      'resources/js/init.js'     
  ], 'public/js/init.js');

mix.js([      
'resources/js/app.js'
], 'public/js').sourceMaps()
*/
   
   



mix.js([      
      'resources/js/app.js'
      ], 'public/js').sourceMaps()


mix.combine([
      'resources/js/init.js',
      'public/js/app.js',            
], 'public/js/all.js');


mix.sass('resources/sass/app.scss', 'public/css')
   .copyDirectory('resources/images', 'public/images');
