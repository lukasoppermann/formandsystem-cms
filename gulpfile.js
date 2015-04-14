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
    // .less('app.less')
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
/*
 |--------------------------------------------------------------------------
 | My Gulp
 |--------------------------------------------------------------------------
 |
 | Some expelnation
 |
 */
// config
var path = {};
  path.cwd = process.cwd();
  path.assets = '/resources/assets/';
  path.dest = '/public/';
  path.less = path.assets+'less/';
  path.css_out = path.dest+'/css/';
  path.js = path.assets+'js/';
  path.js_out = path.dest+'js/';
/*----------------------------*/
// plugin
var gulp = require('gulp');
    log = require('gulp-util').log,
    notify = require('gulp-notify'),
    colors = require('gulp-util').colors,
    // utils
    noop = require('gulp-util').noop,
    file = require('gulp-util').File,
    concat = require('gulp-concat'),
    size = require('gulp-size'),
    // css
    less = require('gulp-less'),
    cssmin = require('gulp-minify-css'),
    colorguard = require('gulp-colorguard'),
    // js
    browserify = require('browserify'),
    uglify = require('gulp-uglify'),
    mocha = require('mocha'),
    // svg
    svgstore = require('gulp-svgstore'),
    svgmin = require('gulp-svgmin'),
    // cheerio = require('gulp-cheerio'), // kick out?
    // php
    phpspec = require('gulp-phpspec'),
    phpunit = require('gulp-phpunit'),
    // analytics
    pagespeed = require('psi') // page speed
    recess = require('gulp-recess') // css quality
;

gulp.task('test', function() {
    gulp.log('Test', gulp.colors.magenta('123'));
    gulp.src('public/js/app.js')
      .pipe(size());
});
// var minifyCSS = require('gulp-minify-css');
// var recess = require('gulp-recess');


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

var foreach = require('gulp-foreach');


gulp.task('csslint', function() {
  gulp.src(['public/css/app.css'])
    .pipe(scsslint({
      config: 'scsslint.yml'
    }))
    ;
});

/* ---------- */
/* utilities */
var notify = function(){

};
/* ---------- */
/* css */
gulp.task('css', function(){
  gulp.src(path.cwd+path.less+'app.less')
    .pipe(less())
    .pipe(colorguard({
      format: 'json'
    }))
      .on('error', function(error){
        log(error.message);
      })
    .pipe(gulp.dest(path.cwd+path.css_out));

});
/* ---------- */
/* javascript */
var source = require('vinyl-source-stream');
gulp.task('javascript', function () {
  // set up the browserify instance on a task basis
  var b = browserify({
    debug: true
  });
  b.add(path.cwd+path.js+'test.js');
  // b.bundle().pipe(process.stdout);
  return b.bundle()
    .pipe(source('yo.js'))
  //   // .pipe(buffer())
  //   // .pipe(sourcemaps.init({loadMaps: true}))
  //   //     // Add transformation tasks to the pipeline here.
  //   //     .pipe(uglify())
  //   //     .on('error', gutil.log)
  //   // .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest(path.cwd+path.js_out));
});
/* ---------- */
/* waches */
gulp.task('watch-css', function(){
  gulp.watch([path.cwd+path.less+'*.less', path.cwd+path.less+'**/*.less'], ['css']);
});
/* ---------- */
/* tasks */
gulp.task('default', ['css', 'watch-css']);
gulp.task('build', ['css']);

/* ---------- */
/* error handling */
var reportError = function(error){
  log(error.message);
};

/* ---------- */

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
