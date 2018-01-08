var gulp = require('gulp');
var sass = require('gulp-sass');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');
var minifyCSS = require('gulp-cssnano');
var package = require('./package.json');
var concat = require('gulp-concat');
var php = require('gulp-connect-php');

gulp.task('css', function () {
    return gulp.src('resources/assets/sass/style.scss')
            .pipe(sass().on('error', sass.logError))
            .pipe(gulp.dest('public/css'))
            .pipe(minifyCSS())
            .pipe(rename({suffix: '.min'}))
            .pipe(gulp.dest('public/css'));
});

gulp.task('js', function () {
    return  gulp.src([
        'node_modules/jquery/dist/jquery.js',
        'node_modules/bootstrap-sass/assets/javascripts/bootstrap.js',
        'resources/assets/js/app.js'
    ]).pipe(concat('all.js'))
      .pipe(gulp.dest('public/js'))
      .pipe(uglify())
      .pipe(rename({suffix: '.min'}))
      .pipe(gulp.dest('public/js'));
});

gulp.task('watch', function () {
    gulp.watch("resources/assets/sass/**/*.scss", ['css']);
    gulp.watch('resources/assets/js/*.js', ['js']);
});

gulp.task('serve', function () {
    php.server({
        base: './public'
    });
});

gulp.task('default', ['css', 'js', 'watch', 'serve'], function () {

});
