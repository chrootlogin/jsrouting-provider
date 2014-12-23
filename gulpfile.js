var gulp = require('gulp'),
    jasmine = require('gulp-jasmine'),
    notify = require('gulp-notify');

gulp.task('default', function() {
    // place code for your default task here
});

gulp.task('test', function() {
    gulp.src('./tests/js/*.test.js')
        .pipe(jasmine())
        .on('error', notify.onError({
            title: 'Jasmine Test Failed',
            message: 'One or more tests failed, see the cli for details.'
        })
    );
});