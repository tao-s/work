var gulp = require('gulp');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var plumber = require('gulp-plumber');

gulp.task('sass', function() {
    gulp.src('./assets/css/*.scss')
        .pipe(plumber())
        .pipe(sass({outputStyle: 'expanded'}))
        .pipe(autoprefixer())
        .pipe(gulp.dest('./assets/css'));
});

gulp.task('default', function() {
    gulp.watch('./assets/css/*.scss', ['sass']);
});
