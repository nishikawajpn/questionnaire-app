'use strict'
var { src, dest, watch, parallel } = require('gulp');
var sass = require('gulp-sass')(require('sass'));
var plumber = require('gulp-plumber');
var browserSync = require('browser-sync');
var postcss = require('gulp-postcss');
var mqpacker = require('css-mqpacker');
var autoprefixer = require('autoprefixer');

const sassBuild = (done) => {
  src(['./_src/sass/**/*.scss', './_src/sass/**/*.sass'])
    .pipe(plumber())
    .pipe(sass({outputStyle: 'expanded'}))
    .pipe(postcss([mqpacker(), autoprefixer()]))
    .pipe(dest('./assets/css'))

  done();
};

const watchFiles = () => {
  watch(['./_src/sass/**/*.scss', './_src/sass/**/*.sass'], sassBuild);
  watch(['./assets/css/**/*.css', './**/*.html'], bsReload);
}

const startBrowserSync = () => {
  browserSync({
    server: {
      baseDir: "./",
      index: "index.html"
    }
  });
}

const sassRelease = (done) => {
  src(['./_src/sass/**/*.scss', './_src/sass/**/*.sass'])
    .pipe(plumber())
    .pipe(sass({outputStyle: 'compressed'}))
    .pipe(dest('./assets/css'));

  done();
}

const bsReload = (done) => {
  browserSync.reload();
  done();
};

exports.default = parallel(startBrowserSync, watchFiles);
exports.build = sassBuild;
exports.release = sassRelease;
