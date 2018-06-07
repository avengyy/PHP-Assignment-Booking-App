const gulp = require('gulp');
const sass = require('gulp-sass');
const rename = require('gulp-rename');
const plumber = require('gulp-plumber');
const browserSync = require('browser-sync');
const autoprefixer = require('gulp-autoprefixer');

function errorLog(err) {
  console.error.bind(err);
  this.emit('end');
}

gulp.task('sass', function() {
  return gulp
    .src('sass/main.scss')
    .pipe(
      sass({
        outputStyle: 'compressed'
      })
    )
    .pipe(autoprefixer())
    .pipe(plumber())
    .pipe(rename('style.css'))
    .pipe(gulp.dest('css/'))
    .pipe(browserSync.stream());
});

gulp.task('serve', ['sass'], function() {
  browserSync.init({
    server: {
      baseDir: './'
    }
  });
  gulp.watch('sass/*.scss', ['sass']);
  gulp.watch('./*html').on('change', browserSync.reload);
});

gulp.task('default', ['serve']);
