var elixir = require('laravel-elixir');

elixir.extend('recess', function(src) {

  var gulp = require('gulp');
  var recess = require('gulp-recess');

  gulp.task('recess', function() {
    gulp.src(src)
    .pipe(recess().on('error',function(error){
    }))
    .pipe(recess.reporter({
      fail: true,
      minimal: false
    }));

  });
  //
  this.registerWatcher("recess", ["resources/assets/less/*.less", "resources/assets/less/*/*.less"]);

  return this.queueTask('recess');

 });
