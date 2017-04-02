const gulp = require('gulp');
const sass = require('gulp-sass');
const sourcemaps = require('gulp-sourcemaps');
const autoprefixer = require('gulp-autoprefixer');
const babel = require('gulp-babel');
const concat = require('gulp-concat');

gulp.task('sass', function () {
    gulp.src('src/App/Resources/assets/scss/*.scss')
        .pipe(sourcemaps.init())
        .pipe(autoprefixer())
        .pipe(sass({ outputStyle: 'compressed' }).on('error', sass.logError))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('public/css/'));
});

gulp.task('javascript', function () {
    return gulp.src('src/App/Resources/assets/js/*.js')
        .pipe(sourcemaps.init())
        .pipe(babel({
            presets: ['es2015']
        }))
        .pipe(concat('app.js'))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('public/js/'));
});

gulp.task('default', function () {
    gulp.watch('src/App/Resources/assets/scss/*.scss', ['sass']);
    gulp.watch('src/App/Resources/assets/js/*.js', ['javascript']);
});
