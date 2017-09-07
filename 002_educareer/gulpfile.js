var gulp = require('gulp'),
    babelify = require('babelify'),
    html = require('html-browserify'),
    browserify = require('browserify'),
    $ = require("gulp-load-plugins")(),
    spritesmith = require('gulp.spritesmith'),
    source = require('vinyl-source-stream'),
    buffer = require('vinyl-buffer'),
    assign = require('lodash.assign'),
    autoprefixer = require('gulp-autoprefixer'),
    watchify = require('watchify');

require('es6-promise').polyfill();

var DEST = "./public",
    SRC  = "./public_src";

var paths = {
  js: [SRC + "/**/*.js", "!" + SRC + "/**/_*.js"],
  css: [SRC + "/**/*.scss", "!" + SRC + "/**/_*.scss"],
  img: [SRC + "/**/*.{png,jpg,gif}"],
  sprite: [SRC + "/images/sprite/*.{png,jpg,gif}"]
};

var customOpts = {
  entries:[SRC + '/js/app.js'],
  extensions: ['.js'],
  transform: [babelify, html],
  debug: true,
},
opts = assign({}, watchify.args, customOpts),
b = watchify(browserify(opts)),
bundle = function() {
  return b.bundle()
    .on('error',  $.util.log.bind($.util), 'Browserify Error')
    .pipe($.plumber())
    .pipe(source('js/app.js'))
    .pipe(buffer())
    .pipe(gulp.dest(DEST));
}

gulp.task('browserify', bundle);
b.on('update', bundle);
b.on('log', $.util.log);

gulp.task('sass', function () {
  gulp.src(paths.css)
    .pipe($.plumber())
    .pipe($.sass().on('error', $.sass.logError))
    .pipe(autoprefixer({
      browsers: ['last 2 versions'],
      cascade: false
    }))
    .pipe(gulp.dest(DEST));
});

gulp.task('sprite', function() {
  var a = gulp.src(paths.sprite).pipe($.plumber()).pipe(spritesmith({
    imgName: 'images/sprite.png',
    cssName: 'css/_sprite.scss',
    imgPath: '/images/sprite.png',
    algorithm: 'binary-tree',
    cssFormat: 'scss',
    padding: 4
  }));
  a.img.pipe(gulp.dest(SRC));
  a.img.pipe(gulp.dest(DEST));
  a.css.pipe(gulp.dest(SRC));
});

gulp.task('watch', function() {
  gulp.watch(paths.css[0], ['sass']);
});

gulp.task('default', ['watch', 'browserify']);
