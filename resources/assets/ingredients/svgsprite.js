var elixir = require('laravel-elixir');

elixir.extend('svgsprite', function() {

  var svgstore = require('gulp-svgstore');
  var gulp = require('gulp');
  var svgmin = require('gulp-svgmin');
  var cheerio = require('gulp-cheerio');

  gulp.task('svgsprite', function() {
  gulp.src('resources/assets/svg/*.svg')
   .pipe(svgmin())
   .pipe(svgstore({ fileName: 'svg-sprite.svg', prefix: 'icon-', inlineSvg: true }))
    .pipe(cheerio({
      run: function ($) {
        $('svg').attr({ style: 'display:none' });
      }
    }))
   .pipe(gulp.dest('public/media/'));
  });

  this.registerWatcher("svgsprite", "resources/assets/svg/*.svg");

  return this.queueTask('svgsprite');

 });
