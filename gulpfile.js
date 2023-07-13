// Подключение модулей
const gulp = require( 'gulp' );
const sass = require( 'gulp-sass' )( require( 'sass' ) );
const rename = require( 'gulp-rename' );
const cleanCSS = require( 'gulp-clean-css' );
const babel = require( 'gulp-babel' );
const uglify = require( 'gulp-uglify' );
const concat = require( 'gulp-concat' );
const sourcemaps = require( 'gulp-sourcemaps' );
const autoprefixer = require( 'gulp-autoprefixer' );
const imagemin = require( 'gulp-imagemin' );
const htmlmin = require( 'gulp-htmlmin' );
const gulppug = require( 'gulp-pug' );
const del = require( 'del' );

// ПУТИ к изначальным файлам и файлу назначения
const paths = {
	pug: {
		src: 'src/*.pug',
		dest: 'dist/'
	},
	html: {
		src: 'src/*.html',
		dest: 'dist/'
	},
	styles: {
		src: [ 'src/styles/**/*.sass', 'src/styles/**/*.scss' ],
		dest: 'dist/css/'
	},
	scripts: {
		src: 'src/scripts/**/*.js',
		dest: 'dist/js/'
	},
	images: {
		src: 'src/img/**',
		dest: 'dist/img/'
	}
};


function clean ()
{
	return del( [ 'dist' ] );
}

// Задача для pug
function pug ()
{
	return gulp.src( paths.pug.src )
		.pipe( gulppug() )
		.pipe( gulp.dest( paths.pug.dest ) );
}


// Задача для минификации html
function html ()
{
	return gulp.src( paths.html.src )
		.pipe( htmlmin( { collapseWhitespace: true } ) )
		.pipe( gulp.dest( paths.html.dest ) );
}

// ЗАДАЧА для обработки стилей
function styles ()
{
	return gulp.src( paths.styles.src )
		.pipe( sourcemaps.init() )
		.pipe( sass().on( 'error', sass.logError ) )
		.pipe( autoprefixer( {
			cascade: false
		} ) )
		.pipe( cleanCSS( {
			level: 2
		} ) )
		.pipe( rename( {
			basename: 'main',
			suffix: '.min'
		} ) )
		.pipe( sourcemaps.write( '.' ) )
		.pipe( gulp.dest( paths.styles.dest ) );
}

// ЗАДАЧА для обработки скриптов
function scripts ()
{
	return gulp.src( paths.scripts.src )
		.pipe( sourcemaps.init() )
		.pipe( babel( {
			presets: [ '@babel/env' ]
		} ) )
		.pipe( uglify() )
		.pipe( concat( 'main.min.js' ) )
		.pipe( sourcemaps.write( '.' ) )
		.pipe( gulp.dest( paths.scripts.dest ) );
}

// Задача сжатия картинок
function img ()
{
	return gulp.src( paths.images.src )
		.pipe( imagemin() )
		.pipe( gulp.dest( paths.images.dest ) );
}


// ЗАДАЧА для подключения наблюдателя
function watch ()
{
	gulp.watch( paths.pug.src, pug );
	gulp.watch( paths.styles.src, styles );
	gulp.watch( paths.scripts.src, scripts );
}

const build = gulp.series( clean, pug, gulp.parallel( styles, scripts, img ), watch );


exports.clean = clean;
exports.img = img;
exports.html = html;
exports.pug = pug;
exports.styles = styles;
exports.scripts = scripts;
exports.watch = watch;
exports.build = build;
exports.default = build;