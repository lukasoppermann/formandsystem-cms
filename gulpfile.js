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
  path.svg = path.assets+'svg/';
  path.svg_out = path.dest+'media/';
  path.buildDir = path.dest+'build/';
// color combinations ignored by colorguard
var colorguardIgnore = [
  ['#ffd200', '#fac800'], // main menu
  ['#f5be00', '#fac800']  // main menu
];
/*----------------------------*/
// plugin
var gulp = require('gulp'),
    log = require('gulp-util').log,
    notify = require('gulp-notify'),
    colors = require('gulp-util').colors,
    cache = require('gulp-cached'),
    // utils
    sourcemaps = require('gulp-sourcemaps'),
    noop = require('gulp-util').noop,
    file = require('gulp-util').File,
    concat = require('gulp-concat'),
    size = require('gulp-size'),
    rename = require('gulp-rename'),
    del = require('del'),
    rev = require('gulp-rev'),
    changed = require('gulp-changed'),
    progeny = require('gulp-progeny'),
    clipEmpty = require('gulp-clip-empty-files'),
    // css
    less = require('gulp-less'),
    autoprefixer = require('gulp-autoprefixer'),
    cssmin = require('gulp-minify-css'),
    colorguard = require('gulp-colorguard'),
    csslint = require('gulp-csslint'),
    cmq = require('gulp-combine-media-queries'),
    // js
    browserify = require('browserify'),
    uglify = require('gulp-uglify'),
    jsmin = require('gulp-jsmin'),
    mocha = require('mocha'),
    jshint = require('gulp-jshint'),
    jscs = require('gulp-jscs');
    // svg
    svgstore = require('gulp-svgstore'),
    svgmin = require('gulp-svgmin'),
    cheerio = require('gulp-cheerio'),
    // php
    phpspec = require('gulp-phpspec'),
    phpunit = require('gulp-phpunit'),
    // analytics
    pagespeed = require('psi') // page speed
;

/* ---------- */
/* utilities */
var notify = function(){

};
/* ---------- */
/* error handling */
var reportError = function(error) {
  if( error.message !== undefined ) {
    log(error.message);
  }else{
    log(error);
  }
};
/* ---------- */
/* css */
csslint.addRule({
  id: 'oocss',
  name: 'OOCSS',
  desc: 'Class names must follow the pattern .(o|c|u|js|qa|is|has)-[a-z0-9-]+((_{2}|-{2})?[a-z0-9-]+)?(-{2}[a-z0-9-]+)?[a-z0-9]',
  browsers: 'All',

  //initialization
  init: function(parser, reporter){
    'use strict';
    var rule = this;
    parser.addListener('startrule', function(event){

      var line        = event.line,
          col         = event.col;

      for (var i=0,len=event.selectors.length; i < len; i++){
        var selectors = event.selectors[i].text.split(/(?=\.)/);
        for (var s=0,l=selectors.length; s < l; s++){
          var selector = selectors[s].trim();
          if(selector.charAt(0) !== '.'){
            return;
          }
          if(!selector.match(/^\.(_)?(o|c|u|js|qa|is|has)-([a-z0-9]|-)+((_{2}|-{2})?[a-z0-9-]+)?(-{2}[a-z0-9-]+)?[a-z0-9]$/)){
            reporter.warn('Bad naming: '+selector, line, col, rule);
          }
        }
      }
    });
  }
});

gulp.task('compile-css', function(cb){
  return gulp.src([path.cwd+path.less+'*.less', path.cwd+path.less+'**/*.less'])
    .pipe(cache('less'))
    .pipe(progeny({
      regexp: /^\s*@import\s*(?:\(\w+\)\s*)?['"]([^'"]+)['"]/
    }))
    .pipe(less())
      .on('error', reportError)
    .pipe(clipEmpty())
    .pipe(autoprefixer({
      browsers: ['last 2 versions'],
      cascade: false
    }))
    .pipe(cmq())
    .pipe(csslint({
      'fallback-colors': false,
      'box-sizing': false,
      'box-model': false,
      'compatible-vendor-prefixes': false,
      'adjoining-classes': true // turn back on
    }))
    .pipe(csslint.reporter())
    .pipe(colorguard({
      format: 'json',
      whitelist: colorguardIgnore
    }))
    .pipe(gulp.dest(path.cwd+path.css_out+'/files/'));

    cb(err);
});

gulp.task('cssmin', ['compile-css'], function(){
  return gulp.src([path.cwd+path.css_out+'/files/*.css', path.cwd+path.css_out+'/files/**/*.css'])
  .pipe(size({
    showFiles: false,
    title: 'compiled less files'
  }))
  .pipe(concat('app.css'))
  .pipe(sourcemaps.init({loadMaps: true}))
    .on('error', reportError)
  .pipe(cssmin())
    .on('error', reportError)
  .pipe(size({
    showFiles: true,
    title: 'minified css file'
  }))
  .pipe(sourcemaps.write('./'))
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
  // b.add([
  //   'vendor/bower_components/jquery/jquery.min.js',
  //   'vendor/bower_components/codemirror/lib/codemirror.js',
  //   'vendor/bower_components/codemirror/mode/css/css.js',
  //   'vendor/bower_components/codemirror/addon/mode/overlay.js',
  //   'vendor/bower_components/codemirror/mode/markdown/markdown.js',
  //   'vendor/bower_components/codemirror/mode/gfm/gfm.js',
  //   'vendor/bower_components/nestable/dist/nestable.jquery.min.js',
  //   // 'vendor/bower_components/keymage/keymage.min.js',
  //   'vendor/bower_components/eventEmitter/EventEmitter.js',
  //   // 'vendor/bower_components/nestable/src/nestable.js',
  //   // 'vendor/bower_components/nestable/src/nestable.functions.js',
  //   // 'vendor/bower_components/nestable/src/nestable.jquery.js',
  //   'resources/assets/js/app-object.js',
  //   'resources/assets/js/templates/*',
  //   'resources/assets/js/data-toggle.js',
  //   'resources/assets/js/data-event.js',
  //   'resources/assets/js/save-page.js',
  //   'resources/assets/js/editor-sections.js',
  //   'resources/assets/js/keyboard-shortcuts.js',
  //   'resources/assets/js/pages/*',
  //   'resources/assets/js/app.js'
  // ]);
  // b.bundle().pipe(process.stdout);
  // return b.bundle()
    gulp.src([
      'resources/assets/js/app-object.js',
      'resources/assets/js/templates/*',
      'resources/assets/js/data-toggle.js',
      'resources/assets/js/data-event.js',
      'resources/assets/js/save-page.js',
      'resources/assets/js/editor-sections.js',
      'resources/assets/js/keyboard-shortcuts.js',
      'resources/assets/js/pages/*',
      'resources/assets/js/app.js'
    ])
    .pipe(jshint())
    .pipe(jshint.reporter('jshint-stylish'))
    .pipe(jscs())
      .on('error', reportError);

    return gulp.src([
      'vendor/bower_components/jquery/jquery.min.js',
      'vendor/bower_components/codemirror/lib/codemirror.js',
      'vendor/bower_components/codemirror/mode/css/css.js',
      'vendor/bower_components/codemirror/addon/mode/overlay.js',
      'vendor/bower_components/codemirror/mode/markdown/markdown.js',
      'vendor/bower_components/codemirror/mode/gfm/gfm.js',
      'vendor/bower_components/nestable/dist/nestable.jquery.min.js',
      'vendor/bower_components/keymage/keymage.min.js',
      'vendor/bower_components/eventEmitter/EventEmitter.min.js',
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
    ])
    // .pipe(buffer())
    .pipe(sourcemaps.init({loadMaps: true}))
    .pipe(concat('app.js'))
    .pipe(size({
      showFiles: true,
      title: 'concatinated js files'
    }))
    .pipe(jsmin())
      .on('error', reportError)
    .pipe(size({
      showFiles: true,
      title: 'minified js files'
    }))
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest(path.cwd+path.js_out));
});
/* ---------- */
/* svg */
gulp.task('svgsprite', function() {
  gulp.src(path.cwd+path.svg+'*.svg')
  .pipe(size({
    title: 'combined size of all individual svg icons'
  }))
  .pipe(svgmin())
  .pipe(rename({prefix: 'svg-icon--'}))
  .pipe(svgstore({inlineSvg: true }))
  .pipe(rename('svg-sprite.svg'))
  .pipe(cheerio({
    run: function ($) {
      $('svg').attr({ style: 'display:none' });
    }
  }))
  .pipe(size({
    showFiles: true,
  }))
  .pipe(gulp.dest(path.cwd+path.svg_out));
});
/* ---------- */
/* waches */
gulp.task('watch-css', function(){
  gulp.watch([path.cwd+path.less+'*.less', path.cwd+path.less+'**/*.less'], ['css']);
});
gulp.task('watch-svgsprite', function(){
  gulp.watch([path.cwd+path.svg+'*.svg'], ['svgsprite']);
});
/* ---------- */
/* rev */
gulp.task('rev', function(){
  del.sync(path.cwd+path.buildDir+'*', { force: true });

  return gulp.src([
      path.cwd+path.css_out+'app.css',
      path.cwd+path.js_out+'app.js',
      path.cwd+path.svg_out+'svg-sprite.svg'
    ], {base: path.cwd+path.dest})
    .pipe(rev())
    .pipe(gulp.dest(path.cwd+path.buildDir))  // write rev'd assets to build dir
    .pipe(rev.manifest())
    .pipe(gulp.dest(path.cwd+path.buildDir)) // write manifest to build dir
    .on('end', function() {
      gulp.src(path.cwd+path.js_out+'app.js.map')
      .pipe(gulp.dest(path.cwd+path.buildDir+'js/'));
      gulp.src(path.cwd+path.css_out+'app.css.map')
      .pipe(gulp.dest(path.cwd+path.buildDir+'css/'));
    });
});
/* ---------- */
/* tasks */
// gulp.task('default', ['css', 'watch-css', 'svgsprite', 'watch-svgsprite']);
gulp.task('css', ['compile-css', 'cssmin']);
gulp.task('build', ['css']);

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
      .pipe(replace(/<\!-- gulp-remove:start -->[\s\S]*?<\!-- gulp-remove:end -->/g,''))
      .pipe(replace(/\r?\n|\r|\s\s/g,''))
      .pipe(replace(/\'/g,'\\\''))
      .pipe(tap(function(file){
        var name = file.path.replace('.blade.php','').replace(file.base,'');
        var content = file.contents;
        fs.writeFile('resources/assets/js/templates/'+name+'.js', 'APP.templates["'+name+'"]="'+content+'";');
      }));

});
