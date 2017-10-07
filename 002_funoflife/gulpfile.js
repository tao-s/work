var gulp = require('gulp');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var plumber = require('gulp-plumber');
var webserver = require('gulp-webserver');

gulp.task('webserver', function() {
  gulp.src('./')
      .pipe(webserver({
        fallback:   'index.html',
        livereload: true,
        directoryListing: {
          enable: true,
          path: './'
        },
        open: true

      }));
});

gulp.task('sass', function() {
    gulp.src('./css/*.scss')
        .pipe(plumber())
        .pipe(sass({outputStyle: 'expanded'}))
        .pipe(autoprefixer())
        .pipe(gulp.dest('./css'));
});

gulp.task('default', function() {
  gulp.watch('./**/*.scss', ['sass']);
});
