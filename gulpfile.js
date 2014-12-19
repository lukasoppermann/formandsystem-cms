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
      // 'vendor/bower_components/jquery/dist/jquery.min.js',
      // 'vendor/bower_components/codemirror/lib/codemirror.js',
      // 'vendor/bower_components/codemirror/mode/css/css.js',
      // 'vendor/bower_components/codemirror/addon/mode/overlay.js',
      // 'vendor/bower_components/codemirror/mode/markdown/markdown.js',
      // 'vendor/bower_components/codemirror/mode/gfm/gfm.js',
      // 'vendor/bower_components/html.sortable/src/html.sortable.js',
      'vendor/bower_components/engine/engine.js',
      "vendor/bower_components/engine/functions/children.js",
      "vendor/bower_components/engine/functions/class.js",
      "vendor/bower_components/engine/functions/css.js",
      "vendor/bower_components/engine/functions/parent.js",
      "vendor/bower_components/engine/functions/on.js",
      "vendor/bower_components/engine/functions/off.js",
      "vendor/bower_components/engine/functions/each.js",
      "vendor/bower_components/engine/functions/create.js",
      "vendor/bower_components/engine/functions/trigger.js",
      'vendor/bower_components/engine-sortable/engine-sortable.js',
      // 'vendor/bower_components/mark/mark.js',
      'resources/assets/js/app.js'
    ], './', 'public/js/app.js')
    .phpSpec();
    // .phpUnit();
});
