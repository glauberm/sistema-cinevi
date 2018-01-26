var gulp = require('gulp');
var del = require('del');
var minifyCSS = require('gulp-csso');
var concat = require('gulp-concat');
var rev = require('gulp-rev');
var babel = require('gulp-babel');
var uglify = require('gulp-uglify');

gulp.task('clean', function () {
    return del([
        './web/css/prod',
        './web/js/prod'
    ]);
});

gulp.task('styles', function () {
    return gulp
        .src([
            './web/css/dev/bootstrap.min.css',
            './web/css/dev/bootstrap-theme.min.css',
            './node_modules/select2/dist/css/select2.min.css',
            './node_modules/select2-bootstrap-theme/dist/select2-bootstrap.min.css',
            './node_modules/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
            './web/bundles/fullcalendar/css/fullcalendar/fullcalendar.min.css',
            './web/css/dev/estilos.css'
        ])
        .pipe(minifyCSS())
        .pipe(concat('main.min.css'))
        .pipe(rev())
        .pipe(gulp.dest('./web/css/prod/'))
    ;
});

gulp.task('scripts', function () {
    return gulp
        .src([
            './node_modules/jquery/dist/jquery.min.js',
            './node_modules/select2/dist/js/select2.min.js',
            './node_modules/select2/dist/js/i18n/pt-BR.js',
            './node_modules/moment/min/moment.min.js',
            './node_modules/moment/locale/pt-br.js',
            './web/js/dev/bootstrap.min.js',
            './node_modules/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
            './node_modules/responsive-toolkit/dist/bootstrap-toolkit.min.js',
            './node_modules/autosize/dist/autosize.min.js',
            './node_modules/jquery-mask-plugin/dist/jquery.mask.min.js',
            './web/bundles/fullcalendar/js/fullcalendar/fullcalendar.min.js',
            './web/bundles/fullcalendar/js/fullcalendar/locale/pt-br.js',
            './web/js/dev/masks.js',
            './web/js/dev/admin.js',
            './web/js/dev/almoxarifado/calendar-event.js',
            './web/js/dev/to-many.js',
            './web/js/dev/realizacao/ficha-tecnica/equipe.js'
        ])
        .pipe(babel())
        .pipe(uglify())
        .pipe(concat('main.min.js'))
        .pipe(rev())
        .pipe(gulp.dest('./web/js/prod/'))
    ;
});

gulp.task('build', [
    'styles',
    'scripts'
]);
