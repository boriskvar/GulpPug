// Подключение модулей
const gulp = require( 'gulp' );
const rename = require( 'gulp-rename' );
const cleanCSS = require( 'gulp-clean-css' );
const sass = require( 'gulp-sass' )( require( 'sass' ) );
const babel = require('gulp-babel')
const uglify = require('gulp-uglify')
const concat = require('gulp-concat')
const del = require( 'del' );

// ПУТИ к изначальным файлам и файлу назначения
const paths = {
	styles: {
		src: [
			'src/styles/**/*.sass',
			'src/styles/**/*.scss',
			'src/styles/**/*.styl',
			'src/styles/**/*.less' ],
		dest: 'dist/css/'
	},
	scripts: {
		src: 'src/scripts/**/*.js',
		dest: 'dist/js/'
	},
};


function clean ()
{
	return del( [ 'dist' ] );
}

// ЗАДАЧА для обработки стилей
function styles ()
{
	return gulp.src( paths.styles.src )
		.pipe( sass() )
		.pipe( cleanCSS() )
		.pipe( rename( {
			basename: 'main',
			suffix: '.min'
		} ) )
		.pipe( gulp.dest( paths.styles.dest ) );
}

// ЗАДАЧА для обработки скриптов
function scripts ()
{
	return gulp.src( paths.scripts.src, {
		sourcemaps: true
	} )
		.pipe( babel() )
		.pipe( uglify() )
		.pipe( concat( 'main.min.js' ) )
		.pipe( gulp.dest( paths.scripts.dest ) )
}

// ЗАДАЧА для подключения наблюдателя
function watch ()
{
	gulp.watch( paths.styles.src, styles )
	gulp.watch( paths.scripts.src, scripts )
}

const build = gulp.series( clean, gulp.parallel( styles, scripts ), watch )


exports.clean = clean;
exports.styles = styles;
exports.scripts = scripts;
exports.watch = watch;
exports.build = build;
exports.default = build;