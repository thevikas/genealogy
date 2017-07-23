var gulp = require('gulp');

/*gulp.task('js', function(){
  return gulp.src([])
    .pipe(gulp.dest('public/js/'))
});*/

gulp.task('css', function(){
  return gulp.src(['../node_modules/bootstrap/dist/css/bootstrap.min.css',
                  '../node_modules/font-awesome/css/font-awesome.min.css'])
    .pipe(gulp.dest('public/css/'))
});

gulp.task('fonts', function(){
  return gulp.src([
        '../node_modules/font-awesome/fonts/*',
        '../node_modules/bootstrap/fonts/*'])
    .pipe(gulp.dest('public/fonts/'))
});

gulp.task('default', [ 'css','fonts' ]);
