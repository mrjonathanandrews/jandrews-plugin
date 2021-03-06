// Load Gulp
var gulp            =   require( 'gulp' );

// CSS related plugins
var sass            =   require( 'gulp-sass' )(require( 'sass' ) );
var autoprefixer    =   require( 'gulp-autoprefixer' );
// var minifycss       =   require( 'gulp-uglifycss' );

// JS related plugins
// var concat          =   require( 'gulp-concat' );
var uglify          =   require( 'gulp-uglify' );
var babelify        =   require( 'babelify' );
var browserify      =   require( 'browserify' );
var source          =   require( 'vinyl-source-stream' );
var buffer          =   require( 'vinyl-buffer' );
var stripDebug      =   require( 'gulp-strip-debug' );

// Utility plugins
var rename          =   require( 'gulp-rename' );
var sourcemaps      =   require( 'gulp-sourcemaps' );
var notify          =   require( 'gulp-notify' );
var plumber         =   require( 'gulp-plumber' );
var options         =   require( 'gulp-options' );
var gulpif          =   require( 'gulp-if' );
const { src } = require('gulp');

// Browser related plugins
var browserSync     =   require( 'browser-sync' ).create();
var reload          =   browserSync.reload;

// Project related variables
var projectURL      =   'https://my-resume.local';

var styleSRC        =   './src/scss/index.scss';
var styleURL        =   './assets/css/';
var mapURL          =   './';

var jsSRC           =   './src/js/index.js';
var jsURL           =   './assets/js/';

var styleWatch      =   './src/scss/**/*.scss';
var jsWatch         =   './src/js/**/*.js';
var phpWatch        =   './**/*.php';

// Tasks
gulp.task( 'browser-sync', async function() {
    browserSync.init({
        proxy: projectURL,
        https: {
            key: '',
            cert: ''
        },
        injectChanges: true,
        open: false
    });
});

gulp.task( 'styles', async function() {
    gulp.src( styleSRC )
        .pipe( rename( { suffix: '.min' } ) )
        .pipe( sourcemaps.init() )
        .pipe( sass({
            errLogToConsole: true,
            outputStyle: 'compressed'
        }) )
        .on( 'error', console.error.bind( console ) )
        .pipe( autoprefixer() )
        .pipe( sourcemaps.write( mapURL ) )
        .pipe( gulp.dest( styleURL ) )
        .pipe( browserSync.stream() );
});

gulp.task( 'js', async function() {
    // return browserify({
    //     entries: [ jsSRC ]
    // })
    gulp.src( jsSRC )
    // .transform( babelify, { presets: [ 'env' ] } )
    // .bundle()
    // .pipe( source( 'index.js' ) )
    // .pipe( buffer() )
    // .pipe( gulpif( options.has( 'production' ), stripDebug() ) )
    // .pipe( sourcemaps.init({ loadMaps: true }) )
    // .pipe( uglify() )
    // .pipe( sourcemaps.write( '.' ) )
    .pipe( gulp.dest( jsURL ) )
    // .pipe( browserSync.stream() );
});

function triggerPlumber( src, url ) {
    return gulp.src( src )
    .pipe( plumber() )
    .pipe( gulp.dest( url ) );
}

gulp.task( 'default', gulp.series( 'styles', 'js' ), async function( compile ) {
    gulp.src( jsURL + 'index.min.js' )
        .pipe( notify({ message: 'Assets Compiled!' }) );
});

gulp.task( 'watch', gulp.series( 'default', 'browser-sync' ), async function() {
    gulp.watch( phpWatch, reload );
    gulp.watch( styleWatch, [ 'styles' ] );
    gulp.watch( jsWatch, [ 'js', reload ] );
    gulp.src( jsURL + 'index.min.js' )
        .pipe( notify({ message: 'Gulp is watching!' }) );
});