var gulp = require( 'gulp' );
var rename = require( 'gulp-rename' );
var sass = require( 'gulp-sass' );
var uglify = require( 'gulp-uglify' );
var autoprefixer = require( 'gulp-autoprefixer' );
var sourcemaps = require( 'gulp-sourcemaps' );

var browserify = require( 'browserify' );
var babelify = require( 'babelify' );
var source = require( 'vinyl-source-stream' );
var buffer = require( 'vinyl-buffer' );

var browserSync = require( 'browser-sync' ).create();
var reload = browserSync.reload;



var styleSRC = 'src/scss/mystyle.scss';
var styleForm = 'src/scss/form.scss';
var styleSlider = 'src/scss/slider.scss';
var styleAuth = 'src/scss/auth.scss';
var styleDIST = './assets/';
var styleWatch = 'src/scss/**/*.scss';

var jsAdmin = 'myscript.js';
var jsForm = 'form.js';
var jsSlider = 'slider.js';
var jsAuth = 'auth.js';
var jsCPT = 'cpt.js';
var jsCF = 'cf.js';
var jsSRC = 'src/js/';
var jsDIST = './assets/';
var jsWatch = 'src/js/**/*.js';
var jsFILES = [ jsAdmin, jsForm, jsSlider, jsAuth, jsCPT, jsCF ];

var phpWatch     = './**/*.php';


//  Browser Sync
gulp.task( 'browser-sync', function() {

    browserSync.init({ server: { baseDir: "./" } });

    // browserSync.init({

    //     // open: false,
    //     // injectChanges: true,
    //     // proxy: "http://niloyplugin.local/"

    //     server: {
    //         baseDir: "./"
    //     }

    // });

} );


//  STYLE COMPILING
gulp.task( 'style', function() {

    gulp.src( [ styleSRC, styleForm, styleSlider, styleAuth ] )
        .pipe( sourcemaps.init() )
        .pipe( sass( {
            errorLogToConsole: true,
            outputStyle: 'compressed'
        } ) )
        .on( 'error', console.error.bind( console ) )
        .pipe( autoprefixer( { 
            browsers: [ 'last 2 versions' ],
            cascade: false
        } ) )
        .pipe( rename( { suffix: '.min' } ) )
        .pipe( sourcemaps.write( './' ) )
        .pipe( gulp.dest( styleDIST ) )
        .pipe( browserSync.stream() );

} );

//  SCRIPT COMPILING
gulp.task( 'js', function() {

    jsFILES.map( function( entry ) {

        return browserify({
            entries: [ jsSRC + entry ]
        })
        .transform( babelify, { presets: [ 'env' ] } )
        .bundle()
        .pipe( source( entry ) )
        .pipe( rename({ extname: '.min.js' }) )
        .pipe( buffer() )
        .pipe( sourcemaps.init({ loadMaps: true }) )
        .pipe( uglify() )
        .pipe( sourcemaps.write( './' ) )
        .pipe( gulp.dest( jsDIST ) )
        .pipe( browserSync.stream() );

    } );

} );


//  Gulp Default Task
gulp.task( 'default', [ 'style', 'js' ] );

//  Gulp WATCH Task
gulp.task( 'watch', [ 'default', 'browser-sync' ], function() {

    gulp.watch( phpWatch, reload );
    gulp.watch( styleWatch, [ 'style', reload ] );
    gulp.watch( jsWatch, [ 'js', reload ] );

} );