//-----------------------
// Gulp check accessibility
 module.exports = function(gulp, access){
  return gulp.src('http://cms.formandsystem.app/')
    .pipe(access({
      force: true
    }))
    .on('error', console.log)
    .pipe(access.report({reportType: 'txt'}))
    .pipe(console.log)
    .pipe(rename({
      extname: '.txt'
    }))
    .pipe(gulp.dest('reports/txt'));
}
