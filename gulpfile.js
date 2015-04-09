var elixir = require('laravel-elixir');
require('./resources/assets/ingredients/svgsprite.js');

// require('./resources/assets/ingredients/recess.js');
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
      'vendor/bower_components/eventEmitter/EventEmitter.js',
      // 'vendor/bower_components/nestable/src/nestable.js',
      // 'vendor/bower_components/nestable/src/nestable.functions.js',
      // 'vendor/bower_components/nestable/src/nestable.jquery.js',
      'resources/assets/js/app-object.js',
      'resources/assets/js/templates/*',
      'resources/assets/js/data-toggle.js',
      'resources/assets/js/data-event.js',
      'resources/assets/js/save-page.js',
      'resources/assets/js/editor-sections.js',
      'resources/assets/js/keyboard-shortcuts.js',
      'resources/assets/js/pages/*',
      'resources/assets/js/app.js'
    ], 'public/js/app.js', './')
    .version(['public/css/app.css','public/js/app.js'])
    .phpSpec();
    // .phpUnit();
});

var gulp = require('gulp');
// var minifyCSS = require('gulp-minify-css');
var recess = require('gulp-recess');


gulp.task('recess', function() {
  gulp.src('public/css/app.css')
  .pipe(recess().on('error',function(error){
  }))
  .pipe(recess.reporter({
    fail: true,
    minimal: false
  }));
});

var scsslint = require('gulp-scss-lint');
var less = require('gulp-less');
var foreach = require('gulp-foreach');


gulp.task('csslint', function() {
  gulp.src(['public/css/app.css'])
    .pipe(scsslint({
      config: 'scsslint.yml'
    }))
    ;
});


var mocha = require('gulp-mocha');

gulp.task('mocha', function () {
    return gulp.src('tests/mocha/*.js', {read: false})
        .pipe(mocha({reporter: 'spec'}));
});

var fs = require('fs');
var tap = require('gulp-tap');
var replace = require('gulp-replace');

gulp.task('templates', function () {
  gulp.src('resources/views/partials/section.blade.php')
      .pipe(replace(/\<\!-- gulp-remove:start --\>[\s\S]*?\<\!-- gulp-remove:end --\>/g,''))
      .pipe(replace(/\r?\n|\r|\s\s/g,''))
      .pipe(replace(/\'/g,'\\\''))
      .pipe(tap(function(file){
        var name = file.path.replace('.blade.php','').replace(file.base,'');
        var content = file.contents;
        console.log(file.contents);
        fs.writeFile('resources/assets/js/templates/'+name+'.js', "APP.templates['"+name+"']='"+content+"';");
      }));

});
