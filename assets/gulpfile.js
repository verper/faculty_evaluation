var gulp = require('gulp');
var sass = require('gulp-sass');
var autoprefixer  = require('gulp-autoprefixer');
var sassGlob = require('gulp-sass-glob');

gulp.task('sass', function () {
    return gulp.src('css/scss/app.scss')
        .pipe(sassGlob())
        .pipe(sass({
            // outputStyle: 'expanded',
            outputStyle: 'compressed'
        })
        .on('error', sass.logError))
        .pipe(autoprefixer({
            browsers: ['last 2 versions'],
            cascade: false
        }))
        .pipe(gulp.dest('css/'));
});

gulp.task('default', ['sass'],function () {
    gulp.watch('css/scss/**/*.scss', ['sass']);
});