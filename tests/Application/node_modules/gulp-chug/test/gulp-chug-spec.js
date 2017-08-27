'use strict';

/**
 * gulp-chug test spec file
 *
 * TODO: Use sinon sandboxes to suppress console output from gulp-chug
 */

var util    = require( 'util' );
var path    = require( 'path' );
var _       = require( 'lodash' );
var pequire = require( 'proxyquire' ).noCallThru();
var sinon   = require( 'sinon' );
var should  = require( 'should' );
var gutil   = require( 'gulp-util' );

var CHUG_PATH = '../index.js';

// Happy-path proxy dependencies
var proxyDeps = {
    fs: {
        writeFileSync: _.noop
    },
    path: {
        relative: _.noop,
        dirname: function () { return 'path-dirname-return' },
        basename: function () { return 'path-basename-return' },
        extname: _.noop,
        join: function () { return 'path-join-return' },
        resolve: function () { return 'path-resolve-return' }
    },
    resolve: {
        sync: _.noop
    },
    'path-join-return': {
        bin: {
            gulp: 'gulp-cli-bin'
        }
    },
    child_process: {
        spawn: function () {
            return {
                on: _.noop,
                stdout: { on: _.noop },
                stderr: { on: _.noop }
            };
        }
    },
    './package.json': {
        name: 'gulp-chug-proxy'
    }
};

// Return proxy dependencies with optional overrides
var getProxyDeps = function ( overrides ) {
    return _.assign( {}, proxyDeps, overrides || {} );
};

describe( 'gulp-chug', function () {

    it( 'emits an error if supplied a stream', function ( done ) {
        var chug = require( CHUG_PATH );
        var stream = chug();
        var streamFile = {
            isNull: function () { return false },
            isStream: function () { return true }
        };
        stream.on( 'error', function ( err ) {
            err.message.should.equal( 'Streams are not supported yet. Pull requests welcome :)' );
            done();
        } );
        stream.write( streamFile );
    } );

    it( 'creates a temporary gulpfile if supplied a buffer', function () {
        var pdeps = getProxyDeps( {
            fs: {
                writeFileSync: sinon.spy()
            }
        } );
        var chug = pequire( CHUG_PATH, pdeps );
        var stream = chug();
        var streamFile = {
            isNull:     function () { return false },
            isStream:   function () { return false },
            isBuffer:   function () { return true },
            contents: 'file-contents'
        };
        stream.write( streamFile );

        pdeps.fs.writeFileSync.calledOnce.should.be.true;
        pdeps.fs.writeFileSync.calledWith( 'path-join-return', streamFile.contents ).should.be.true;
    } );

    describe( 'during failures to find a local gulp', function () {

        var ERR_MSG_BEGIN = 'Problem finding locally-installed `gulp` for gulpfile';

        var streamFile = {
            isNull:     function () { return false },
            isStream:   function () { return false },
            isBuffer:   function () { return false }
        };

        it( 'emits an error if a local gulp cannot be found', function ( done ) {
            var pdeps = getProxyDeps( {
                resolve: { sync: function () { throw new Error() } }
            } );
            var chug = pequire( CHUG_PATH, pdeps );
            var stream = chug();
            stream.on( 'error', function ( err ) {
                err.message.should.startWith( ERR_MSG_BEGIN );
                done();
            } );
            stream.write( streamFile );
        } );

        it( 'emits an error if the local gulp\'s package file cannot be parsed', function ( done ) {
            var pdeps = getProxyDeps( {
                path: _.assign( {}, getProxyDeps().path, {
                    dirname: function () { return 'dirname-return' },
                    join: function ( a, b ) {
                        if( a === 'dirname-return' && b === 'package.json' ) {
                            throw new Error();
                        }
                    }
                } )
            } );
            var chug = pequire( CHUG_PATH, pdeps );
            var stream = chug();
            stream.on( 'error', function ( err ) {
                err.message.should.startWith( ERR_MSG_BEGIN );
                done();
            } );
            stream.write( streamFile );
        } );

        it( 'emits an error if the local gulp\'s package file does not contain a binary path', function ( done ) {
            var pdeps = getProxyDeps( { 'path-join-return': {} } );
            var chug = pequire( CHUG_PATH, pdeps );
            var stream = chug();
            stream.on( 'error', function ( err ) {
                err.message.should.startWith( ERR_MSG_BEGIN );
                done();
            } );
            stream.write( streamFile );
        } );
    } );

    it( 'spawns a process to execute the target gulpfile', function () {
        var pdeps = getProxyDeps( {
            child_process: {
                spawn: sinon.spy( function () {
                    return {
                        on: _.noop,
                        stdout: { on: _.noop },
                        stderr: { on: _.noop }
                    };
                } )
            }
        } );
        var chug = pequire( CHUG_PATH, pdeps );
        var stream = chug();
        var streamFile = {
            isNull:     function () { return false },
            isStream:   function () { return false },
            isBuffer:   function () { return false }
        };
        stream.write( streamFile );

        pdeps.child_process.spawn.calledOnce.should.be.true;
        pdeps.child_process.spawn.calledWith(
            'node',
            [ 'path-resolve-return', '--gulpfile', 'path-basename-return', 'default' ],
            { cwd: 'path-dirname-return' }
        ).should.be.true;
    } );

    it( 'supports multiple tasks if provided', function () {

      // Additional string argument
      var pdeps = getProxyDeps( {
        child_process: {
          spawn: sinon.spy( function () {
            return {
              on: _.noop,
              stdout: { on: _.noop },
              stderr: { on: _.noop }
            };
          } )
        }
      } );
      var chug = pequire( CHUG_PATH, pdeps );
      var stream = chug( {
        tasks: ['task1', 'task2']
      } );
      var streamFile = {
        isNull:     function () { return false },
        isStream:   function () { return false },
        isBuffer:   function () { return false }
      };
      stream.write( streamFile );

      pdeps.child_process.spawn.calledOnce.should.be.true;
      pdeps.child_process.spawn.calledWith(
        'node',
        [
        'path-resolve-return', '--gulpfile', 'path-basename-return',
        'task1', 'task2'
        ],
        { cwd: 'path-dirname-return' }
      ).should.be.true;
    } );

    it( 'supports additional command-line arguments if provided', function () {

        // Additional string argument
        var pdeps = getProxyDeps( {
            child_process: {
                spawn: sinon.spy( function () {
                    return {
                        on: _.noop,
                        stdout: { on: _.noop },
                        stderr: { on: _.noop }
                    };
                } )
            }
        } );
        var chug = pequire( CHUG_PATH, pdeps );
        var stream = chug( {
            args: 'fake-arg-1'
        } );
        var streamFile = {
            isNull:     function () { return false },
            isStream:   function () { return false },
            isBuffer:   function () { return false }
        };
        stream.write( streamFile );

        pdeps.child_process.spawn.calledOnce.should.be.true;
        pdeps.child_process.spawn.calledWith(
            'node',
            [
                'path-resolve-return', '--gulpfile', 'path-basename-return',
                'default', 'fake-arg-1'
            ],
            { cwd: 'path-dirname-return' }
        ).should.be.true;

        // Additinal array arguments
        pdeps.child_process.spawn.reset();
        chug = pequire( CHUG_PATH, pdeps );
        stream = chug( {
            args: [ 'fake-arg-2', 'fake-arg-3' ]
        } );
        streamFile = {
            isNull:     function () { return false },
            isStream:   function () { return false },
            isBuffer:   function () { return false }
        };
        stream.write( streamFile );

        pdeps.child_process.spawn.calledOnce.should.be.true;
        pdeps.child_process.spawn.calledWith(
            'node',
            [
                'path-resolve-return', '--gulpfile', 'path-basename-return',
                'default', 'fake-arg-2', 'fake-arg-3'
            ],
            { cwd: 'path-dirname-return' }
        ).should.be.true();
    } );

    it( 'supports a callback to be executed after the target gulpfile has completed executing', function () {
        var cbSpy = sinon.spy();

        var pdeps = getProxyDeps( {
            child_process: {
                spawn: function () {
                    return {
                        on: function ( event, callback ) {
                            if ( event === 'exit' ) {
                                callback( 0 );
                            }
                        },
                        stdout: { on: _.noop },
                        stderr: { on: _.noop }
                    };
                }
            }
        } );
        var chug = pequire( CHUG_PATH, pdeps );

        var stream = chug( cbSpy );
        var streamFile = {
            isNull:     function () { return false },
            isStream:   function () { return false },
            isBuffer:   function () { return false }
        };
        stream.write( streamFile );
        cbSpy.calledOnce.should.be.true();

        cbSpy.reset()
        stream = chug( {}, cbSpy );
        var streamFile = {
            isNull:     function () { return false },
            isStream:   function () { return false },
            isBuffer:   function () { return false }
        };
        stream.write( streamFile );
        cbSpy.calledOnce.should.be.true();
    } );

    it( 'handles spawn errors', function ( done ) {
        var ERR_MSG_BEGIN = 'Error executing gulpfile';
        var pdeps = getProxyDeps( {
            child_process: {
                spawn: function () {
                    return {
                        on: function ( event, fn ) { if ( event === 'error' ) fn() },
                        stdout: { on: _.noop },
                        stderr: { on: _.noop }
                    };
                }
            }
        } );
        var chug = pequire( CHUG_PATH, pdeps );
        var stream = chug();
        stream.on( 'error', function ( err ) {
            err.message.should.startWith( ERR_MSG_BEGIN );
            done();
        } );
        var streamFile = {
            isNull:     function () { return false },
            isStream:   function () { return false },
            isBuffer:   function () { return false }
        };
        stream.write( streamFile );
    } );

    it( 'handles non-zero exit codes from spawned child gulpfiles', function ( done ) {
        var ERR_MSG_PATTERN = /Gulpfile .* exited with an error :\(/;
        var pdeps = getProxyDeps( {
            child_process: {
                spawn: function () {
                    return {
                        on: function ( event, fn ) { if ( event === 'exit' ) fn( 1 ) },
                        stdout: { on: _.noop },
                        stderr: { on: _.noop }
                    };
                }
            }
        } );
        var chug = pequire( CHUG_PATH, pdeps );
        var stream = chug();
        var streamFile = {
            isNull:     function () { return false },
            isStream:   function () { return false },
            isBuffer:   function () { return false }
        };
        stream.on( 'error', function ( err ) {
            err.message.should.match( ERR_MSG_PATTERN );
            done();
        } );
        stream.write( streamFile );
    } );

    it( 'outputs stdout and stderr of the target gulpfile during execution', function () {
        var stdoutSpy = new sinon.spy();
        var stderrSpy = new sinon.spy();
        var pdeps = getProxyDeps( {
            child_process: {
                spawn: function () {
                    return {
                        on: _.noop,
                        stdout: { on: stdoutSpy },
                        stderr: { on: stderrSpy }
                    };
                }
            }
        } );
        var chug = pequire( CHUG_PATH, pdeps );
        var stream = chug();
        var streamFile = {
            isNull:     function () { return false },
            isStream:   function () { return false },
            isBuffer:   function () { return false }
        };
        stream.write( streamFile );

        stdoutSpy.calledOnce.should.be.true();
        stdoutSpy.calledWith( 'data' ).should.be.true();
        stderrSpy.calledOnce.should.be.true();
        stderrSpy.calledWith( 'data' ).should.be.true();
    } );

    it( 'cleans up any temporary gulpfiles on exit', function () {
        var pdeps = getProxyDeps( {
            fs: {
                writeFileSync: _.noop,
                unlinkSync: sinon.spy()
            },
            child_process: {
                spawn: function () {
                    return {
                        on: function ( event, fn ) {
                            if ( event === 'exit' ) fn( 0 );
                        },
                        stdout: { on: _.noop },
                        stderr: { on: _.noop }
                    };
                }
            }
        } );
        var chug = pequire( CHUG_PATH, pdeps );
        var stream = chug();
        var streamFile = {
            isNull:     function () { return false },
            isStream:   function () { return false },
            isBuffer:   function () { return true }
        };
        stream.write( streamFile );
        pdeps.fs.unlinkSync.calledOnce.should.be.true();
        pdeps.fs.unlinkSync.calledWith( 'path-join-return' ).should.be.true();
    } );
} );
