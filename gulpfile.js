// Imports
var gulp = require('gulp');
var mainBowerFiles = require('main-bower-files');
var rename = require('gulp-rename');
var rev = require('gulp-rev');
var del = require('del');
var prefix = require('gulp-autoprefixer');
var less = require('gulp-less');
var concat = require('gulp-concat');
var jsmin = require('gulp-jsmin');
var cleanCSS = require('gulp-clean-css');
var plumber = require('gulp-plumber');
var svgmin = require('gulp-svgmin');
var svgstore = require('gulp-svgstore');
var cheerio = require('gulp-cheerio');
var notify = require('gulp-notify');
// actions
gulp.task('clean-build', function(done){
    del(['public/build']).then(function(){
        done();
    });
});

gulp.task('build-css', ['clean-build'], function(){
    return gulp.src(['resources/less/*'])
    .pipe(plumber({errorHandler: notify.onError("Error: <%= error.message %>")}))
    .pipe(less())
    .pipe(concat('app.css'))
    .pipe(prefix({
        browsers: ['last 4 versions', 'IE 9', 'IE 8'],
        cascade: false
    }))
    .pipe(cleanCSS())
    .pipe(gulp.dest('public/build/css'));
});
// external css
gulp.task('build-external-css', ['clean-build'], function(){
    return gulp.src(['resources/less/external/*'])
    .pipe(plumber({errorHandler: notify.onError("Error: <%= error.message %>")}))
    .pipe(less())
    .pipe(concat('external.css'))
    .pipe(prefix({
        browsers: ['last 4 versions', 'IE 9', 'IE 8'],
        cascade: false
    }))
    .pipe(cleanCSS())
    .pipe(gulp.dest('public/build/css'));
});
//
gulp.task('build-js', ['clean-build'], function(){
    var files = [];
    // var files = mainBowerFiles(['**/*.js'],{
    //     paths: {
    //         bowerDirectory: 'resources/bower_components',
    //         bowerJson: 'bower.json'
    //     }
    // });
    // push prism stuff
    files.push(
        // 'resources/bower_components/prism/components/prism-php.js',
    );
    // push rest of js files
    files.push('resources/js/*.js');

    return gulp.src(files)
    .pipe(concat('app.js'))
    .pipe(jsmin())
    .pipe(gulp.dest('public/build/js'));
});
// build external js
gulp.task('build-external-js', ['clean-build'], function(){
    var files = [];
    // push files
    files.push(
        // 'resources/bower_components/prism/components/prism-php.js',
    );
    files.push('resources/js/external/*.js');

    return gulp.src(files)
    .pipe(concat('external.js'))
    .pipe(jsmin())
    .pipe(gulp.dest('public/build/js'));
});

gulp.task('rev', ['build-external-js','build-external-css','build-js', 'build-css','svgsprite'], function(){
    return gulp.src(['public/build/css/app.css','public/build/css/external.css', 'public/build/js/app.js', 'public/build/js/external.js','public/build/svgs/svg-sprite.svg'], {base: 'public/build'})
    .pipe(rev())
    .pipe(gulp.dest('public/build'))
    .pipe(rev.manifest())
    .pipe(gulp.dest('public/build'));
});

// gulp.task('svg-rev', ['svgsprite'], function(){
//     gulp.src(['public/build/svgs/svg-sprite.svg'], {base: 'public/build'})
//     .pipe(rev())
//     .pipe(gulp.dest('public/build'));
//
//     return del(['public/build/svgs/*.svg']);
// });
//
gulp.task('clean-build-step', ['rev'], function(){
    return del(['public/build/css/app.css','public/build/css/external.css', 'public/build/js/app.js', 'public/build/js/external.js', 'public/build/js/app.js','public/build/svgs/svg-sprite.svg']);
});

/* ---------- */
/* svg */
gulp.task('svgsprite', ['clean-build'], function() {
  gulp.src('resources/svgs/*.svg')
  .pipe(svgmin({
      plugins: [{
          removeAttrs: {
              attrs: 'fill=[^url]*'
          }
      }]
  }))
  .pipe(rename({prefix: 'svg-icon--'}))
  .pipe(svgstore({inlineSvg: true }))
  .pipe(rename('svg-sprite.svg'))
  .pipe(cheerio({
    run: function ($) {
      $('svg').attr({ style: 'display:none' });
    }
  }))
  .pipe(gulp.dest('public/build/svgs'));
});

// gulp watch
gulp.task('asset-watch', function(){
    gulp.watch(['resources/less/*','resources/less/**/*', 'resources/js/*', 'resources/js/external/*'], ['build-css','build-external-css', 'build-js','build-external-js','rev', 'clean-build-step']);
});
gulp.task('svg-watch', function(){
    gulp.watch(['resources/svg/*'], ['svgsprite']);
});

// gulp tasks
gulp.task('default', ['clean-build', 'build-css','build-external-css', 'build-js','build-external-js', 'svgsprite', 'rev', 'clean-build-step','asset-watch','svg-watch']);
