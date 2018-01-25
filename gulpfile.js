var gulp = require('gulp');
var del = require('del');
var less = require('gulp-less');
var minifyCSS = require('gulp-csso');
var concat = require('gulp-concat');
var rev = require('gulp-rev');
var babel = require('gulp-babel');
var uglify = require('gulp-uglify');

gulp.task('clean', function () {
    return del(['assets/prod']);
});

gulp.task('styles', function () {
    return gulp
        .src([
            './web/css/dev/styles/bootstrap.min.less',
            './node_modules/magnific-popup/dist/magnific-popup.css',
            './node_modules/slick-carousel/slick/slick.less',
            './web/css/dev/styles/styles.less'
        ])
        .pipe(less())
        .pipe(minifyCSS())
        .pipe(concat('main.min.css'))
        .pipe(rev())
        .pipe(gulp.dest('./web/css/prod/css/'))
    ;
});

gulp.task('scripts', function () {
    return gulp
        .src([
            './node_modules/bootstrap/js/tab.js',
            './node_modules/magnific-popup/dist/jquery.magnific-popup.min.js',
            './node_modules/slick-carousel/slick/slick.min.js',
            './web/js/dev/scripts/scripts.js',
        ])
        .pipe(babel())
        .pipe(uglify())
        .pipe(concat('main.min.js'))
        .pipe(rev())
        .pipe(gulp.dest('./web/js/prod/js/'))
    ;
});

gulp.task('build', [
    'styles',
    'scripts'
]);
