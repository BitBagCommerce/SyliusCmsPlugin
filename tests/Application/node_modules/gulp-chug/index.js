'use strict';

var fs          = require( 'fs' );
var path        = require( 'path' );
var util        = require( 'util' );
var spawn       = require( 'child_process' ).spawn;

var _           = require( 'lodash' );
var through     = require( 'through2' );
var resolve     = require( 'resolve' );
var gutil       = require( 'gulp-util' );
var PluginError = gutil.PluginError;

var PKG         = require( './package.json' );

// Primary gulp function
module.exports = function ( options, userCallback ) {

    // Consider `options` the callback if it's a function
    if ( _.isFunction( options ) ) {
        userCallback = options;
        options = {};
    }

    // Set default options
    var opts = _.assign( {
        nodeCmd: 'node',
        tasks: [ 'default' ]
    }, options );

    // Set the callback to a noop if it's not a function
    userCallback = _.isFunction( userCallback ) ? userCallback : _.noop

    // Create a stream through which each file will pass
    return through.obj( function ( file, enc, callback ) {

        // Grab reference to this through object
        var self = this;

        // Since we're not modifying the gulpfile, always push it back on the
        // stream.
        self.push( file );

        // Configure logging and errors
        var say = function( msg, noNewLine ) {
            if ( !noNewLine ) {
                return console.log(
                    util.format( '[%s]', gutil.colors.green( PKG.name ) ), msg
                );
            }
            process.stdout.write( util.format( '[%s]', gutil.colors.green( PKG.name ) ) + ' ' + msg )
        };

        var sayErr = function( errMsg ) {
            self.emit( 'error', new PluginError( PKG.name, errMsg ) );
        };

        // Error if file contents is stream ( { buffer: false } in gulp.src )
        // TODO: Add support for a streams
        if ( file.isStream() ) {
            sayErr( 'Streams are not supported yet. Pull requests welcome :)' );
            return callback();
        }

        // Gather target gulpfile info
        var gulpfile = {};
        gulpfile.path       = file.path;
        gulpfile.relPath    = path.relative( process.cwd(), gulpfile.path );
        gulpfile.base       = path.dirname( file.path );
        gulpfile.relBase    = path.relative( process.cwd(), gulpfile.base );
        gulpfile.name       = path.basename( gulpfile.path );
        gulpfile.ext        = path.extname( gulpfile.name );

        // If file contents is null, { read: false }, just execute file as-is
        // on disk
        if( file.isNull() ){
            say( util.format(
                'Gulpfile, %s, contents is empty. Reading directly from disk...',
                gulpfile.name
            ) );
        }

        // If file contents is a buffer, write a temp file and run that instead
        if( file.isBuffer() ) {

            say( 'File is a buffer. Need to write buffer to temp file...' );

            var tmpGulpfileName = util.format(
                '%s.tmp.%s%s',
                path.basename( gulpfile.name, gulpfile.ext ),
                new Date().getTime(),
                gulpfile.ext
            );

            // Tweak gulpfile info to account for temp file
            gulpfile.origPath       = gulpfile.path;
            gulpfile.path           = path.join( gulpfile.base, tmpGulpfileName );
            gulpfile.tmpPath        = gulpfile.path;
            gulpfile.origRelPath    = gulpfile.relPath;
            gulpfile.relPath        = path.relative( process.cwd(), gulpfile.path );
            gulpfile.name           = tmpGulpfileName;

            say( util.format(
                'Writing buffer to %s...',
                gutil.colors.magenta( gulpfile.relPath )
            ) );

            // Write tmp file to disk
            fs.writeFileSync( gulpfile.path, file.contents );
        }

        // Find local gulp cli script
        var localGulpPackage        = null;
        var localGulpPackageBase    = null;
        var localGulpCliPath        = null;
        try {
            localGulpPackageBase    = path.dirname( resolve.sync( 'gulp', { basedir: gulpfile.base } ) );
            localGulpPackage        = require( path.join( localGulpPackageBase, 'package.json' ) );
            localGulpCliPath        = path.resolve( path.join( localGulpPackageBase, localGulpPackage.bin.gulp ) );
        } catch( err ) {
            sayErr( util.format(
                'Problem finding locally-installed `gulp` for gulpfile %s. ' +
                '(Try running `npm install gulp` from %s to install a local ' +
                'gulp for said gulpfile.)\n\n%s',
                gutil.colors.magenta( gulpfile.origPath ),
                gutil.colors.magenta( gulpfile.base ),
                err
            ) );
            return callback();
        }

        // Construct command and args
        var cmd = opts.nodeCmd;

        var args = [
            localGulpCliPath, '--gulpfile', gulpfile.name
        ].concat(opts.tasks);

        // Concatinate additional command-line arguments if provided
        if ( _.isArray( opts.args ) || _.isString( opts.args ) ) {
            args = args.concat( opts.args );
        }

        say(
            'Spawning process ' + gutil.colors.magenta( localGulpCliPath ) +
            ' with args ' + gutil.colors.magenta( args.join( ' ' ) ) +
            ' from directory ' + gutil.colors.magenta( gulpfile.base ) + '...'
        );

        // Execute local gulpfile cli script
        var spawnedGulp = spawn( cmd, args, { cwd: gulpfile.base } );

        // Log output coming from gulpfile stdout and stderr
        var logGulpfileOutput = function ( data ) {
            say( util.format( '(%s) %s',
                gutil.colors.magenta( gulpfile.relPath ),
                data.toString()
            ), true );
        };

        // Remove temp file if one exists
        var cleanupTmpFile = function () {
            try {
                if( gulpfile.tmpPath ) {
                    say( util.format( 'Removing temp file %s', gulpfile.tmpPath ) );
                    fs.unlinkSync( gulpfile.tmpPath );
                }
            } catch ( e ) {
                // Wrap in try/catch because when executed due to ctrl+c,
                // we can't unlink the file
            }
        };

        // Handle errors in gulpfile
        spawnedGulp.on( 'error', function ( error ) {
            sayErr( util.format(
                'Error executing gulpfile %s:\n\n%s',
                gutil.colors.magenta( gulpfile.path ),
                error
            ) );
        } );

        // Handle gulpfile stdout and stderr
        spawnedGulp.stdout.on( 'data', logGulpfileOutput );
        spawnedGulp.stderr.on( 'data', logGulpfileOutput );

        // Clean up temp gulpfile exit
        spawnedGulp.on( 'exit', function ( exitCode ) {
            cleanupTmpFile();

            if ( exitCode === 0 ) {
                say( 'Returning to parent gulpfile...' );
            } else {
                sayErr( util.format(
                    'Gulpfile %s exited with an error :(',
                    gutil.colors.magenta( gulpfile.path )
                ) );
            }

            // Run the stream callback
            callback();

            // Run user callback
            userCallback();
        } );

        // Clean up temp gulpfile if on ctrl + c
        process.on( 'SIGINT', cleanupTmpFile );
    } );
};
