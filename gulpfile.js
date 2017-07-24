var gulp = require('gulp');

gulp.task('js', function(){
  return gulp.src(['react-apps/node_modules/jquery/dist/jquery.min.js',
                'node_modules/d3/build/d3.min.js',
                'react-apps/node_modules/jquery-ui-dist/jquery-ui.min.js'])
    .pipe(gulp.dest('js/'))
});

gulp.task('css', function(){
  return gulp.src(['react-apps/node_modules/bootstrap/dist/css/bootstrap.min.css',
                  'react-apps/node_modules/jquery-ui-dist/jquery-ui.min.css',
                  'react-apps/node_modules/font-awesome/css/font-awesome.min.css'])
    .pipe(gulp.dest('css/'))
});

gulp.task('images', function(){
  return gulp.src(['react-apps/node_modules/jquery-ui-dist/images/*'])
    .pipe(gulp.dest('images/'))
});

gulp.task('fonts', function(){
  return gulp.src([
        'react-apps/node_modules/font-awesome/fonts/*',
        'react-apps/node_modules/bootstrap/fonts/*'])
    .pipe(gulp.dest('fonts/'))
});

gulp.task('default', [ 'js','images','css','fonts' ]);
