const gulp         = require('gulp');
const autoprefixer = require('gulp-autoprefixer');
const babel        = require('gulp-babel');
const cleanCSS     = require('gulp-clean-css');
const concat       = require('gulp-concat');
const rename       = require('gulp-rename');
const sass         = require('gulp-sass');
const sourcemaps   = require('gulp-sourcemaps');
const uglify       = require('gulp-uglify');
const pump         = require('pump');

let sassFiles = 'assets/scss/*.scss';
let jsFiles   = 'assets/js/*.js';
let dest      = 'public/assets/';

gulp.task('sass', function () {
    return gulp.src(sassFiles)
        .pipe(sourcemaps.init())
        .pipe(autoprefixer())
        .pipe(sass().on('error', sass.logError))
        .pipe(concat('app.css'))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest(dest + 'css/'));
});

gulp.task('javascript', function () {
    return gulp.src(jsFiles)
        .pipe(sourcemaps.init())
        .pipe(babel({
            presets: ['env']
        }))
        .pipe(concat('app.js'))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest(dest + 'js/'));
});

gulp.task('minify-css', function () {
    return gulp.src(dest + 'css/*.css')
        .pipe(cleanCSS())
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest(dest + 'css/'));
});

gulp.task('minify-js', function (cb) {
    pump([
        gulp.src(dest + 'js/*.js'),
        uglify(),
        rename({ suffix: '.min' }),
        gulp.dest(dest + 'js/')
    ], cb);
});

gulp.task('minify', ['minify-css', 'minify-js']);

gulp.task('build', ['sass', 'javascript']);

gulp.task('prod', ['build', 'minify']);

gulp.task('watch', function () {
    gulp.watch(sassFiles, ['sass']);
    gulp.watch(jsFiles, ['javascript']);
});

gulp.task('default', ['build', 'watch']);
