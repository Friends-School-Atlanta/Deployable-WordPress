var gulp = require('gulp');

var sass = require('gulp-sass');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');

// Compile Our Sass
gulp.task('sass', function() {
    return gulp.src('custom/scss/main.scss')
        .pipe(sass())
        .pipe(gulp.dest('custom/css/'));
});


// Watch Files For Changes
gulp.task('watch', function() {
    //gulp.watch('js/*.js', ['lint', 'scripts']);
    gulp.watch('custom/scss/*.scss', ['sass']);
});

// Default Task
gulp.task('default', ['sass', 'watch']);

