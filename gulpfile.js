var elixir = require('laravel-elixir');

require('./resources/assets/ingredients/svgsprite.js');
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
    mix
    .less('app.less')
    .svgsprite()
    .scripts([
      'vendor/bower_components/jquery/jquery.min.js',
      'vendor/bower_components/codemirror/lib/codemirror.js',
      'vendor/bower_components/codemirror/mode/css/css.js',
      'vendor/bower_components/codemirror/addon/mode/overlay.js',
      'vendor/bower_components/codemirror/mode/markdown/markdown.js',
      'vendor/bower_components/codemirror/mode/gfm/gfm.js',
      'vendor/bower_components/nestable/dist/nestable.jquery.min.js',
      'vendor/bower_components/keymage/keymage.min.js',
      // 'vendor/bower_components/nestable/src/nestable.js',
      // 'vendor/bower_components/nestable/src/nestable.functions.js',
      // 'vendor/bower_components/nestable/src/nestable.jquery.js',
      'resources/assets/js/app.js',
      'resources/assets/js/save-page.js',
      'resources/assets/js/keyboard-shortcuts.js'
    ], 'public/js/app.js', './')
    .version(['public/css/app.css','public/js/app.js'])
    .phpSpec();
    // .phpUnit();
});
