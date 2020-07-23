"use strict";
/**
 * Imports
 */
const gulp          = require('gulp');
const sass          = require('gulp-sass');
const cssnano       = require('gulp-cssnano');
const sourcemaps    = require('gulp-sourcemaps');
const concat        = require('gulp-concat');
const uglify        = require('gulp-uglify');
const phplint       = require('gulp-phplint');
const rename		    = require('gulp-rename');

/**
 * Sass
 */
var sassFiles = [
  './src/assets/sass/load.scss'
]
function css() {
  return  gulp
    .src(sassFiles)
    .pipe(sourcemaps.init())
    .pipe(sass({ outputStyle: "expanded" }))
    .pipe(cssnano())
    .pipe(rename('style.css'))
    .pipe(sourcemaps.write('./assets/sourcemaps'))
    .pipe(gulp.dest('./dist'));
}

/**
 * JavaScript
 */
var jsFiles = [
	'./src/assets/js/scripts.js'
];
function js() {
  return (
    gulp
    .src(jsFiles)
    .pipe(concat('./scripts.js'))
    .pipe(uglify())
    .pipe(gulp.dest('./dist'))
  );
}

/**
 * PHP Task
 */
var phpFiles = [
  './src/**/*.php'
]
function php() {
  return (
    gulp
    .src(phpFiles)
    .pipe(phplint('', { skipPassedFiles: true }))
    .pipe(gulp.dest('./dist'))
  );
}
/**
 * Imagens
 */
var imagensFiles = [
  './src/**/*.png',
  './src/**/*/jpg'
]
function imagens() {
  return (
    gulp
    .src('./src/**/*.png')
    .pipe(gulp.dest('./dist'))
  )
}
/**
 * Watch Task
 */
function watchFiles() {
  gulp.watch(imagensFiles, gulp.series(imagens));
  gulp.watch(sassFiles, gulp.series(css));
  gulp.watch(jsFiles, gulp.series(js));
  gulp.watch(phpFiles, gulp.series(php));
}

const build = gulp.series(css, js, php, imagens);
const watch = gulp.series(watchFiles);

exports.default = build;
exports.watch = watch;