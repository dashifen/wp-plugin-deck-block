const {src, dest, parallel, task, watch} = require('gulp'),
  browserify = require('browserify'),
  buffer = require('vinyl-buffer'),
  sass = require('gulp-sass'),
  source = require('vinyl-source-stream'),
  uglify = require('gulp-uglify');

function js() {
  return browserify({entries: ['assets/scripts/index.js']})
    .transform('babelify', {presets: ['@babel/preset-env', '@babel/preset-react']})
    .bundle()
    .pipe(source('deck-block.min.js'))
    .pipe(buffer())
    .pipe(uglify())
    .pipe(dest('assets'));
}

function css() {
  return src('assets/styles/deck-block.scss')
    .pipe(sass({outputStyle: 'compressed'}))
    .pipe(dest('assets'));
}

function build() {
  parallel(js, css);
}

function watcher() {
  js();
  css();
  watch(['assets/scripts/**/*.js'], js);
  watch(['assets/styles/**/*.scss'], css);
}

task('js', js);
task('sass', css);
task('default', build);
task('watch', watcher);
