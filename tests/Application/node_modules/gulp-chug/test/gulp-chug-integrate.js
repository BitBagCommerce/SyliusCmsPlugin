'use strict';

/**
 * gulp-chug integration "tests" to assure a working state in a less-contrived
 * environment.
 *
 * This is basically a normal gulpfile that runs gulp-chug through some common
 * scenarios.
 *
 * Integration "tests" pass if this gulpfile runs without error.
 */

var gulp        = require( 'gulp' );
var replace     = require( 'gulp-replace' );
var chug        = require( '../index.js' );

// Happy path
gulp.task( 'happy', function () {
    return gulp.src( './subproj/gulpfile.js' )
        .pipe( chug() );
} );

// Custom gulpfile file name
gulp.task( 'custom-filename', function () {
    return gulp.src( './subproj/gulpfile-custom-name.js' )
        .pipe( chug() );
} );

// Custom gulpfile file name
gulp.task( 'custom-filename-multiple-tasks', function () {
  return gulp.src( './subproj/gulpfile-custom-name.js' )
  .pipe( chug({tasks:['task1', 'task2']}) );
} );

// Nested gulpfile
gulp.task( 'deep-nest', function () {
    return gulp.src( './subproj/subdir/gulpfile.js' )
        .pipe( chug() );
} );

gulp.task( 'deep-nest-multiple-tasks', function () {
  return gulp.src( './subproj/subdir/gulpfile.js' )
  .pipe( chug({tasks:['task1', 'task2']}) );
} );

// Glob multiple gulpfiles
gulp.task( 'glob', function () {
    return gulp.src( './subproj/**/gulpfile*.js' )
        .pipe( chug() );
} );

gulp.task( 'glob-multiple-tasks', function () {
  return gulp.src( './subproj/**/gulpfile*.js' )
  .pipe( chug({tasks:['task1', 'task2']}) );
} );

// Non-existant gulpfile
gulp.task( 'non-existant', function () {
    return gulp.src( './subproj/non-existant-file.js' )
        .pipe( chug() );
} );

// No-read option
gulp.task( 'no-read', function () {
    return gulp.src( './subproj/gulpfile.js', { read: false } )
        .pipe( chug() );
} );

// Mess with the gulpfile before running
gulp.task( 'modify-before', function () {
    return gulp.src( './subproj/gulpfile.js' )
        .pipe( replace( 'Hello', 'Goodbye' ) )
        .pipe( chug() );
} );

gulp.task( 'default', [
    'happy',
    'custom-filename',
    'custom-filename-multiple-tasks',
    'deep-nest',
    'deep-nest-multiple-tasks',
    'glob',
    'glob-multiple-tasks',
    'non-existant',
    'no-read',
    'modify-before'
] );
