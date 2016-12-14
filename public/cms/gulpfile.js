/* ------------------------------------------------------------------------------
 *
 *  # Gulp file
 *
 *  Basic Gulp tasks for Limitless template
 *
 *  Version: 1.0
 *  Latest update: Dec 2, 2015
 *
 * ---------------------------------------------------------------------------- */


// Include gulp
var gulp = require('gulp'); 


// Include our plugins
var jshint = require('gulp-jshint');
var less = require('gulp-less');
var minifyCss = require('gulp-minify-css');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');


// Lint task
gulp.task('lint', function() {
    return gulp
        .src('assets/js/core/app.js')                 // lint core JS file. Or specify another path
        .pipe(jshint())
        .pipe(jshint.reporter('default'));
});


// Compile our less files
gulp.task('less', function() {
    return gulp
        .src('assets/less/_main/*.less')              // locate /less/ folder root to grab 4 main files
        .pipe(less())                                 // compile
        .pipe(gulp.dest('assets/css'))                // destination path for normal CSS
        .pipe(minifyCss({                             // minify CSS
            keepSpecialComments: 0                    // remove all comments
        }))
        .pipe(rename({                                // rename file
            suffix: ".min"                            // add *.min suffix
        }))
        .pipe(gulp.dest('assets/css'));               // destination path for minified CSS
});


// Concatenate & minify JS (uncomment if you want to use)
/*gulp.task('concatenate', function() {
    return gulp
        .src('assets/js/*.js')                        // path to js files you want to concat
        .pipe(concat('all.js'))                       // output file name
        .pipe(gulp.dest('assets/js'))                 // destination path for normal JS
        .pipe(rename({                                // rename file
            suffix: ".min"                            // add *.min suffix
        }))
        .pipe(uglify())                               // compress JS
        .pipe(gulp.dest('assets/js'));                // destination path for minified JS
});*/


// Minify template's core JS file
gulp.task('minify_core', function() {
    return gulp
        .src('assets/js/core/app.js')                 // path to app.js file
        .pipe(uglify())                               // compress JS
        .pipe(rename({                                // rename file
            suffix: ".min"                            // add *.min suffix
        }))
        .pipe(gulp.dest('assets/js/core/'));          // destination path for minified file
});


// Watch files for changes
gulp.task('watch', function() {
    gulp.watch('assets/js/core/app.js', [             // listen for changes in app.js file and automatically compress
        'lint',                                       // lint
        //'concatenate',                              // concatenate & minify JS files (uncomment if in use)
        'minify_core'                                 // compress app.js
    ]); 
    gulp.watch('assets/less/**/*.less', ['less']);    // listen for changes in all LESS files and automatically re-compile
});


// Default task
gulp.task('default', [                                // list of default tasks
    'lint',                                           // lint
    'less',                                           // less compile
    //'concatenate',                                  // uncomment if in use
    'minify_core',                                    // compress app.js
    'watch'                                           // watch for changes
]);
