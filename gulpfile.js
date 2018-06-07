var gulp = require('gulp');
var watch = require('gulp-watch');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
var plumber = require('gulp-plumber');
var neat = require('bourbon-neat');


gulp.task('sass', function () {
  gulp.src('styles/scss/main.scss')
    .pipe(plumber())
    .pipe(sourcemaps.init())
    .pipe(sass({
      includePaths: require('bourbon-neat').includePaths,
      outputStyle: 'compressed'
    }))
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest('styles/css'));
});



gulp.task('watch', function () {
  gulp.watch(['styles/scss/*.scss'], ['sass']);
});