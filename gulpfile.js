const gulp = require('gulp'),
  browserify = require('browserify'),
  buffer = require('vinyl-buffer'),
  sass = require('gulp-sass'),
  source = require('vinyl-source-stream'),
  uglify = require('gulp-uglify');

function compileJs() {
  return browserify({entries: ['assets/scripts/index.js']})
    .transform('babelify', {presets: ['@babel/preset-env', '@babel/preset-react']})
    .bundle()
    .pipe(source('deck-block.min.js'))
    .pipe(buffer())
    .pipe(uglify())
    .pipe(gulp.dest('assets'));
}

function compileSass() {
  return gulp.src('assets/styles/deck-block.scss')
    .pipe(sass({outputStyle: 'compressed'}))
    .pipe(gulp.dest('assets'));
}

function buildTask() {
  compileSass();
  compileJs();
}

gulp.task('js', compileJs);
gulp.task('sass', compileSass);
gulp.task('default', buildTask);
