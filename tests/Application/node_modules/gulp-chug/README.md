# gulp-chug [![NPM version][npm-badge-img]][npm-url] [![Build Status](https://travis-ci.org/robatron/gulp-chug.png?branch=master)](https://travis-ci.org/robatron/gulp-chug) [![Dependency Status](https://david-dm.org/robatron/gulp-chug.png)](https://david-dm.org/robatron/gulp-chug)

> A [gulp][gulp-url] plugin for running external gulpfiles as part of a gulp task inside another gulpfile.

gulp-chug is *non-modifying*, i.e., gulp-chug will return the same stream it
receives. See [Use with other plugins](#use-with-other-plugins) for an example.

Requires [node](//nodejs.org) >= 0.10

Inspired by [shama](https://github.com/shama)'s [grunt-hub](https://github.com/shama/grunt-hub).

**Note:** This plugin has been [blacklisted](https://github.com/gulpjs/plugins/issues/93), however I have yet to find an example of a pattern that allows for the execution of child gulpfiles without task name collisions. If you have an example, let me know!

## Install

Install with [npm](https://npmjs.org/package/gulp-chug):

```sh
npm install gulp-chug
```


## Usage

### Run external gulpfiles

Run one external gulpfile:

```js
var gulp = require( 'gulp' );
var chug = require( 'gulp-chug' );

gulp.task( 'default', function () {
    gulp.src( './subproj/gulpfile.js' )
        .pipe( chug() )
} );
```

Run multiple external gulpfiles:

```js
var gulp = require( 'gulp' );
var chug = require( 'gulp-chug' );

gulp.task( 'default', function () {

    // Find and run all gulpfiles under all subdirectories
    gulp.src( './**/gulpfile.js' )
        .pipe( chug() )
} );
```

### Use with other plugins

grunt-chug will not modify streams passed to it, but will happily accept
streams modified by other plugins:

```js
var gulp = require( 'gulp' );
var chug = require( 'gulp-chug' );
var replace = require( 'gulp-replace' );

gulp.task( 'default', function () {
    gulp.src( './subproj/gulpfile.js' )

        // Transform stream with gulp-replace
        .pipe( replace( 'Hello', 'Goodbye' ) )

        // Run modified stream with gulp-chug
        .pipe( chug() )
} );
```

### Make gulp-chug faster by ignoring file contents

If gulp-chug is the only plugin in the stream, there's no need to actually read
the contents of the gulpfiles. Set `{ read: false }` in `gulp.src` to speed
things up:

```js
var gulp = require( 'gulp' );
var chug = require( 'gulp-chug' );

gulp.task( 'default', function () {
    gulp.src( './subproj/gulpfile.js', { read: false } )
        .pipe( chug() )
} );
```
## Options

Gulp chug supports several options, all of which are **optional**, e.g.,

```js
var gulp = require( 'gulp' );
var chug = require( 'gulp-chug' );

gulp.task( 'default', function () {
    gulp.src( './subproj/gulpfile.js' )
        .pipe( chug( {
            nodeCmd: 'node',
            tasks:  [ 'default' ],
            args:   [ '--my-arg-1', '--my-arg-2' ]
        } ) );
} );
```

### tasks

The tasks to run from each gulpfile. Default is `default`.

```js
chug( {
    tasks: [ 'my-task-1', 'my-task-2' ]
} )
```

### nodeCmd

The node command to spawn when running gulpfiles. Default is `node`.

```js
chug( {
    nodeCmd: './my-node-bin'
} )
```

### args

Additional command-line arguments to pass to each spawned process. Default is
none.

```js
chug( {
    args: [ '--my-arg-1', '--my-arg-2' ]
} )
```

## Callback

You can pass a callback function to gulp chug that will be executed after the
external gulpfile has finished running.

```js
var gulp = require( 'gulp' );
var chug = require( 'gulp-chug' );

gulp.task( 'default', function () {

    gulp.src( './subproj/gulpfile.js' )
        .pipe( chug( function () {
            console.log( 'Done' );
        } ) )
} );
```

In combination with gulp-chug options:

```js
var gulp = require( 'gulp' );
var chug = require( 'gulp-chug' );

gulp.task( 'default', function () {

    gulp.src( './subproj/gulpfile.js' )
        .pipe( chug( {
            tasks: [ 'my-task-1', 'my-task-2' ]
        }, function () {
            console.log( 'Done' );
        } ) )
} );
```

## See also

- [gulp-hub](https://github.com/frankwallis/gulp-hub) - Load tasks from other gulpfiles

## Changelog

### 0.4

- Add option to pass additional command-line arguments to each gulpfile
- Update deps

### 0.3

- Add `nodeCmd` option to choose one's own node binary to spawn
- Add error handling for spawned processes
- Update deps

### 0.2

- Use `child_process.spawn` instead of `child_process.exec` for real-time child gulpfile output (see [exec vs spawn](http://www.hacksparrow.com/difference-between-spawn-and-exec-of-node-js-child_process.html))
- Implement proper unit tests
- Fix bug where temp gulpfile would be written to the glob base instead of as a sibling to the original gulpfile

### 0.1

- Initial release

## License

The MIT License (MIT)

Copyright (c) 2014 Rob McGuire-Dale

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

[npm-badge-img]: https://badge.fury.io/js/gulp-chug.png
[npm-url]: https://npmjs.org/package/gulp-chug
[gulp-url]: https://github.com/wearefractal/gulp
