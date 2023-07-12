<?php 
//https://gulpjs.com/docs/en/getting-started/quick-start
 npm init -y
 npm install --save-dev gulp

//? 1 вставим в [gulpfile.js] код из док-ии
function defaultTask(cb) {
  // place code for your default task here
  cb();
}

exports.default = defaultTask
//^ gulp
//----------------------
//? в [gulpfile.js]  удалим весь код
//* БЫЛО
/* 
function defaultTask(cb) { //* УДАЛИМ
  // place code for your default task here
  cb();
}

exports.default = defaultTask
*/
//* СТАЛО
const gulp = require('gulp') //* с пом [require()]-подключим плагин[gulp] (т.к. мы его уже установили и он появился в папке[node-modules], название[gulp] соответст-т тому назв-ю кот есть в [package.json]("gulp": "^4.0.2")). И закинем все, в константу с произв ИМЕНЕМ[gulp]

------------------------
// https://www.npmjs.com/package/gulp
//https://www.npmjs.com/package/del
//^ [del] плагин
//? 1 УСТАНОВКА [del] - в терминале наберем[npm i del] + укажем [-D] (чтобы в dev)
//^ npm i del -D
/* 
  "devDependencies": {
    "del": "^7.0.0", //* установился (но не работает)
    "del": "^6.1.1", //*  'del'- установился (и работает)
  }
*/
//------------------------

//? 2 ПОДКЛЮЧЕНИЕ [del]
//? 2 в [gulpfile.js] укажем

const del = require('del')//* с пом [require()]-подключим плагин[del] (т.к. мы его уже установили и он появился в папке[node-modules], название[del] соответст-т тому назв-ю кот есть в [package.json]("del": "^6.1.1")). И закинем все, в константу с произв ИМЕНЕМ[del]

//? 3  проверим работу ПЛАГИНа[del]

function clean() { //* 1 назовем ф-ю[clean()] (для очистки каталога любого)
  return del(['dist']) //* 2 вернем модуль[del], в круглых скобках передадим МАССИВ (ЧТО МЫ ХОТИМ ОЧИСТИТЬ). ['dist']-это б наш каталог в кот будет финальная версия кода (уже скомпилир-й js, преобразованный из препроцессоров - CSS). А в каталоге ['src']-мы б вести разработку
}

//? 3.1 создадим эти 2 каталога: ['dist'] and ['src']

//? 3.2 сделаем ЭКСПОРТ (как в базовом примере)
function clean() {
  return del(['dist'])
}

exports.clean = clean   //^ 1 так мы запустим Ф-ИЮ[clean()] (в экспорт закинем значение Ф-ИИ[clean()])

//? 3.2.1 создадим в ['dist'] файл[style.css]
//? 3.2.1 создадим в ['dist'] файл[main.js]


//? 3.2.2 и попробуем, как работает наша задача, кот мы записали. В терминале наберем [gulp clean]- для удаления папки[dist]
//^ ЗАДАЧА_1 [ gulp clean ]

//~ видим, что папка[dist] - УДАЛЕНА
//!---4---Константа с ПУТЯМИ[Paths]--------
//^ [const paths]
//это пути к нашим файлам
/* 
? создадим ПАПКУ[styles] 
[src\styles]
  ? создадим файл[main.scss]

? создадим ПАПКУ[scripts] 
[src\scripts]
  ? создадим файл[main.js]
*/
//? [gulpfile.js]

// Подключение модулей
const gulp = require('gulp')
const del = require('del')

// пути к изначальным файлам и файлу назначения
const paths = { //^ 1 объект
	styles: {
    src: 'src/styles/**/*.scss',
    dest: 'dist/css/'
  },
  scripts: {
    src: 'src/scripts/**/*.js',
    dest: 'dist/js/'
  },
}
/* 
[**/]-обознач любую вложенность из каталогов (внутри каталога[styles])
[/*.scss] - обозн что файл д б с расширением[scss] 
[dest]-пункт назначения[dist/css/] (пока [dist]-удален, и внут папка[css]-тоже)
*/

function clean() {
  return del(['dist'])
}


exports.clean = clean
//------------------------

//? создадим[index.html] и ПОДКЛЮЧИМ СТИЛИ[.css] и СКРИПТЫ[.js]
//[src\index.html]
/* 
<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta
			name="viewport"
			content="width=device-width, initial-scale=1.0"
		>
		<link       //* 1 подключим стиль...
			rel="stylesheet"
			href="dist/css/main.min.css" //* ...из файла[main.min.css] (его еще нет)
		>
		<title>Document</title>
	</head>

	<body>

    <script src="dist/js/main.min.js"></script> //* 2 подкл СКРИПТ из файла[main.min.js] (его еще нет)
	</body>

</html>
*/
//^ обработка стилей
//? [gulpfile.js]
// Подключение модулей
const gulp = require('gulp')
const del = require('del')

// пути к изначальным файлам и файлу назначения
const paths = {     //^ ОБЪЕКТ{paths}
	styles: { //^  ОБЪЕКТ{styles}
    src: 'src/styles/**/*.sass', //^ ключ[src]  (т.е. отсюда берем)
    dest: 'dist/css/' //^ ключ[dest]  (т.е. сюда вставим)
  },
	scripts: { //^                     ОБЪЕКТ{scripts}
    src: 'src/scripts/**/*.js', //^ ключ[src]  (т.е. отсюда берем)
    dest: 'dist/js/' //^           ключ[dest]  (т.е. сюда вставим)
  },
}


function clean() {
  return del(['dist'])
}

// Задача для обработки стилей
function styles() {
//return gulp.crc('src/styles/**/*.scss') //можно так, или см ниже...
  return gulp.src(paths.styles.src) //^ 1 ОБЪЕКТ{paths}, ОБЪЕКТ{styles}, ключ[src]  (т.е. ОТСЮДА берем...)
    .pipe(sass()) //^ 2 ВЫЗОВ плагина[sass] (обычная ф-я[sass()])
    .pipe(gulp.dest(paths.styles.dest))//^ 3 ОБЪЕКТ{paths},ОБЪЕКТ{styles},ключ[dest] (...а СЮДА вставим)(пока этого каталога[dest] - НЕТ)
}

exports.clean = clean
exports.styles = styles //^ 4 ЭКСПОРТИРУЕМ задачу[styles()] ("styles"-это название ЗАДАЧИ)
//-----------------------------------------------

//^ npm i gulp-sass -D
//^ npm i sass -D
// npm uninstall less  - так удаляем ненужный плагин
//----------------------------------------------

//? проверим работу задачи[styles()]
//^ gulp styles
//~ видим, что появились папки[dist\css\] и файл[main.css]
//------------------------------------
-----------------

//^ gulp-clean-css
//? 1 установим ПЛАГИН[gulp-clean-css]
/* 
https://www.npmjs.com/package/gulp-clean-css
*/
//?  в терминале: [npm i gulp-clean-css]  + укажем [-D] 
//^  npm i gulp-clean-css -D

/* 
  "devDependencies": {
    "gulp-clean-css": "^4.3.0", //* установился "gulp-clean-css"
  }
*/
//^ gulp-rename
//? 2 установим ПЛАГИН[gulp-rename]
/* 
https://www.npmjs.com/package/gulp-rename
*/
//?  в терминале: [npm i gulp-rename]  + укажем [-D]
//^  npm i gulp-rename -D

/* 
  "devDependencies": {
    "gulp-rename": "^2.0.0", //* установился "gulp-rename" (м устанавливать СУФФИКСЫ и ПРЕФИКСЫ и ПЕРЕИМЕНОВЫВАТЬ ФАЙЛЫ)
  }
*/
---------------------

//? [gulpfile.js]
const rename = require('gulp-rename') //* подключаем ПЛАГИН[gulp-rename]
const cleanCSS = require('gulp-clean-css') //* подключаем ПЛАГИН[gulp-clean-css]
//? тепеть используем эти ПЛАГИНЫ в Ф-ИИ[styles()]

function styles() {
  return gulp.src(paths.styles.src)
    .pipe(sass())
    .pipe(cleanCSS()) //* 1 удалит все пробелы,';', абзаци, и оптим-т код 
    .pipe(rename({
      basename: 'main', //* 2 сначала[main] (href="dist/css/main.min.css")
      suffix: '.min' //* 2.1 затем[min] (href="dist/css/main.min.css")
    }))
    .pipe(gulp.dest(paths.styles.dest))
}
//? проверим (наберем в терминале [gulp styles])
//^ [gulp styles]
//~ появился файл[dist\css\main.min.css]
---------------------
//* но нам надо чтобы все предыдущие файлы УДАЛЯЛИСЬ
//------------------
//!---7--- очистка/удаление папки[dist] ------------

//? в [gulpfile.js] создадим Ф-Ю[watch()]

// Задача для обработки стилей
function styles() {
  return gulp.src(paths.styles.src)
    .pipe(sass())
		.pipe(cleanCSS())
		.pipe(rename({
      basename: 'main',
      suffix: '.min'
    }))
    .pipe(gulp.dest(paths.styles.dest))
}
function watch() {
  gulp.watch(paths.styles.src, styles) //^ 1 если в [paths.styles.src] что-то изм-ся то запустить ЗАДАЧУ/Ф-Ю[styles()]
}

exports.watch = watch //^ 2 [экспортируем задачу[watch]]=укажем название Ф-И[watch()]

//-------------------------------
//? проверим: наберем в терминале[gulp watch]
//^ [gulp watch]
//? [Ctrl]+[c] - остановка НАБЛЮДАТЕЛя(watcher)
//-------------------------------------------

//^ series()
//? series() - выполняет ЗАДАЧИ ПОСЛЕДОВАТЕЛЬНО
//? parallel() - выполняет ЗАДАЧИ ПАРАЛЕЛЬНО

const build = gulp.series(clean, styles, watch) //* 1 Ф-Я[clean]-очищает наш каталог, Ф-Я[styles]-обработает стили, Ф-Я[watch]-запустит "наблюдателя"

exports.build = build  //* 2 сработает от команды[gulp build]
exports.default = build //* 3 сработает от команды[gulp]

//? в ТЕРМИНАЛЕ наберем[gulp]
//^ [gulp]
//--------------------------------
//!---8--- обработка скриптов - настроим js -------
//? [gulpfile.js]

// ЗАДАЧА для обработки скриптов
function scripts ()
{
	return gulp.src( paths.scripts.src, {
		sourcemaps: true
	} )
		.pipe( babel() );
}
//--------------------------------------------
/*
^ npm i -D gulp-babel
^ npm i -D gulp-concat
- объед неск файлов в один
^ npm i -D gulp-uglify
- позвол минифицировать js-код
^ npm i -D @babel/core
- это ядро babel 
^ npm i -D @babel/preset-env
?  [gulpfile.js] подключим все что добавили

const babel = require('gulp-babel')
const uglify = require('gulp-uglify')
const concat = require('gulp-concat')
-------------------------
 */
//-------------------------------------------
//? [gulpfile.js]
// ПУТИ к изначальным файлам и файлу назначения
const paths = { //^ ОБЪЕКТ{paths}

	scripts: { //^ ОБЪЕКТ{scripts}
    src: 'src/scripts/**/*.js', //^ 1 отсюда[main.js] - берем
    dest: 'dist/js/' //^ сюда вставим (в созд папку[js])
  },
};

// Задача для обработки скриптов
function scripts() {
  return gulp.src(paths.scripts.src, { //^ 1 ОБЪЕКТ{paths}, ОБЪЕКТ{scripts}, ключ[src]  (т.е. ОТСЮДА[main.js] берем...)
    sourcemaps: true
  })
  .pipe(babel()) //* так мы вызвали[babel](старые версии...)
  .pipe(uglify()) //* так мы вызвали[uglify](минифицирует и сожмет все)
  .pipe(concat('main.min.js')) //* объеденит все файлы в ОДИН с НАЗВАНИЕМ[main.min.js]
  .pipe(gulp.dest(paths.scripts.dest)) //* указ КУДА Б ЗАПИСЫВАТЬ(dest: 'dist/js/') 
}
// ЗАДАЧА - ГОТОВА, но чтобы ее проверить - надо ее ЭКСПОРТИРОВАТЬ

exports.scripts = scripts //* [exports.scripts](import scripts) = [scripts](function scripts())
-------------------------

//? ДОБАВИМ ОТСЛЕЖИВАНИЕ ИЗМЕНЕНИЙ В [src\scripts\main.js] 

// Задача для подключения наблюдателя
function watch() {
  gulp.watch(paths.styles.src, styles)
  gulp.watch(paths.scripts.src, scripts) //^ наблюдать за папкой[src], и если она изменится применить ЗАДАЧУ[scripts] (т.е. Ф-Ю[scripts()])
}

const build = gulp.series( clean, gulp.parallel( styles, scripts ), watch ) //^ gulp.parallel() - вып паралельно и скрипты и стили
-----------------


/* 
? [src\scripts\classes.js]
class Task {
	constructor() {
		console.log("Создам экземпляр task!");
	}

	showId() {
		console.log(23);
	}

	static loadAll() {
		console.log("Загружаем все tasks...");
	}
}
? [src\scripts\main.js]
console.log(typeof Task); //function
let task = new Task(); //"Создан экземпляр task!"
task.showId(); //23
Task.loadAll(); // "Загрузить все tasks..."
-------------------------------------------

--------------------------------
? преобразовываются(объединяются) в один файл [dist\js\main.min.js]

class Task { 
	constructor () { 
		console.log( "Создам экземпляр task!" ); 
	} 
	showId () { 
		console.log( 23 ); 
	} 
	static loadAll () { 
		console.log( "Загружаем все tasks..." ); 
	} 
}
console.log( typeof Task ); 
let task = new Task; 
task.showId(), 
Task.loadAll();
*/
//! ---9--- Повторное использование сборки ---
//? создадим [.gitignore]
/node_modules  //* исключим из добавлений в git-репозиторий
/dist  //* исключим из добавлений в git-репозиторий
package-lock.json  //* исключим из добавлений в git-репозиторий
// каталог указ с пом слеша[/], а файл - просто пишем его название(без слеша)
//* можно исключить каталог[src], но тогда надо будет эти файлы самостоятельно создавать, или мы удалим все что в каталоге[src] есть(ФАЙЛ[src\scripts\classes.js] и ФАЙЛ[src\scripts\main.js]) (чтобы не добавлять лишний код в репозиторий), а ОСТАВИТЬ САМУ СТРУКТРУРУ 
//? УДАЛИМ ФАЙЛ[src\scripts\classes.js] и ФАЙЛ[src\scripts\main.js]
//----------------------
//? создадим [README.md]
# Простая сборка Gulp
//----------------------
//? создадим РЕПОЗИТОРИЙ[GulpPug]
//https://github.com/boriskvar/GulpPug
/* 
git init //* эту ком уже выполнили нажав:"инициал-ть репозиторий"
git commit -m "first commit" //* пишем назв[first version] и клик по "Фиксация"
git branch -M main //* пишем назв[first version] и клик по "Фиксация"
git remote add origin https://github.com/boriskvar/GulpPug.git //^ 1 вставим эту команду в терминале
git push -u origin main   //^ 1 вставим эту команду в терминале
*/
//но вручную надо создать [src]+[scripts]+[styles]
//---------------------
//!---10-плагины [gulp-sourcemaps] + [gulp-autoprefixer] + [Babel] --------
//? [src\index.html]
/* 
<!DOCTYPE html>
<html lang="ru">

	<head>
		<meta charset="UTF-8">
		<meta
			name="viewport"
			content="width=device-width, initial-scale=1.0"
		>
		<link
			rel="stylesheet"
			href="dist/css/main.min.css"
		>
		<title>Project Name</title>
	</head>

	<body>
		<p>Hello World</p> //* 1 добавил
		<script src="dist/js/main.min.js"></script>
	</body>

</html>
*/
//-----------------------

// https://www.npmjs.com/package/gulp-sourcemaps


//? 1 установим[gulp-sourcemaps]
// ^ npm i gulp-sourcemaps -D

//? 2 подключим его в [gulpfile.js]
const sourcemaps = require('gulp-sourcemaps') //* [sourcemaps]- это название мы придумали

//? 3 используем этот ПЛАГИН в [styles()] (по их док-ии примеру)

// Задача для обработки стилей
function styles() {
  return gulp.src(paths.styles.src)
    .pipe(sourcemaps.init()) //* 1 его инициализация
    .pipe(less())
    .pipe(cleanCSS())
    .pipe(rename({
      basename: 'main',
      suffix: '.min'
    }))
    .pipe(sourcemaps.write()) //* 2 записываем нашу карту кот б создана
    .pipe(gulp.dest(paths.styles.dest))
}

//? ТЕРМИНАЛ наберем: gulp
//^ [gulp]
//~
//--------------------------------------
//? используем этот ПЛАГИН в [scripts()] (по их док-ии примеру)
//* БЫЛО
/* 
// Задача для обработки скриптов
function scripts() {
  return gulp.src(paths.scripts.src, {
    sourcemaps: true //* 1 УДАЛИМ т.к. это было по умолчанию
  })
  //* 2 сюда добавим [.pipe(sourcemaps.init())]
  .pipe(babel()) //*  4 параметром настройку из док-ии [{presets: ['@babel/env'] 
  }]   
  .pipe(uglify())
  .pipe(concat('main.min.js'))
  //* 3 сюда добавим какой-то путь [.pipe(sourcemaps.write())]
  .pipe(gulp.dest(paths.scripts.dest))
}
*/
//* СТАЛО
// Задача для обработки скриптов
function scripts() {
  return gulp.src(paths.scripts.src)
  .pipe(sourcemaps.init())        //* 2
  .pipe(babel({
    presets: ['@babel/env'] //* 4 настройка из док-ии
  }))
  .pipe(uglify())
  .pipe(concat('main.min.js'))
  .pipe(sourcemaps.write('.'))    //* 3 //* ['.']-так б создаваться отд-й файл[dist\js\main.min.js.map] карты
  .pipe(gulp.dest(paths.scripts.dest))
}
//---------------------------

//? установим [gulp-autoprefixer]
/* 
https://www.npmjs.com/package/gulp-autoprefixer
будет добавлять префиксы для разных стилей для разных браузеров
*/
//^ npm i gulp-autoprefixer -D

//? подключим его в [gulpfile.js]
const autoprefixer = require('gulp-autoprefixer')

//? вызовем его

// Задача для обработки стилей
function styles() {
  return gulp.src(paths.styles.src)
    .pipe(sourcemaps.init())
    .pipe(less())
    .pipe(autoprefixer({ //* 1
      cascade: false
    }))
    .pipe(cleanCSS())
    .pipe(rename({
      basename: 'main',
      suffix: '.min'
    }))
    .pipe(sourcemaps.write('.')) //* ['.']-так б создаваться отд-й файл[dist\css\main.min.css.map] карты
    .pipe(gulp.dest(paths.styles.dest))
}
--------------------------
//^ npm i -D @babel/preset-env
---------------------------

//!---11--- [gulp-imagemin]  Сжатие изображений ---------------
/* док-я
https://www.npmjs.com/package/gulp-imagemin
Custom plugin options
// …
.pipe(imagemin([
	imagemin.gifsicle({interlaced: true}),
	imagemin.mozjpeg({quality: 75, progressive: true}),
	imagemin.optipng({optimizationLevel: 5}),
	imagemin.svgo({ //^ SVG м понадобится...
		plugins: [
			{removeViewBox: true},
			{cleanupIDs: false}
		]
	})
]))
// …
*/
//? 1 УСТАНОВИМ [gulp-imagemin]
//^ npm i gulp-imagemin -D
или
// npm install --save-dev gulp-imagemin

//? 2 ПОДКЛЮЧИМ в [gulpfile.js]
// Подключение модулей
const imagemin = require('gulp-imagemin') //* 1
// import imagemin from 'gulp-imagemin'; //* 1 или это???

//? 3 в [gulpfile.js] создадим новую Ф-Ю[img()]

// Задача сжатия картинок
function img() {  //* 1 создадим новую Ф-Ю[img()]
  return gulp.src('paths.images.src')  //* отсюда берем['src/images/*']...
        .pipe(imagemin())
        .pipe(gulp.dest('paths.images.dest'))  //* сюда вставляем['dist/images']
}
// пути к изначальным файлам и файлу назначения
const paths = {

  images: {
    src: 'src/img/*', //* ПУТЬ откуда берем['src/img/*']
    dest: 'dist/img' //* ПУТЬ куда вставляем['dist/img']
  }
}
//? 4 экспортируем эту Ф-Ю[img()] в виде отд задачи

exports.img = img //экспортируем в виде отдельной ЗАДАЧИ

//? 5 вставим в финальный[build]

const build = gulp.series(clean, gulp.parallel(styles, scripts, img), watch) //* паралельно со стилями и скриптами добавим task[img]
-----------------------------

//? 6 СОЗДАДИМ ПАПКУ[src\img]
//----------------------


//!---12--- [HTMLmin] Минификация HTML ------
/* 
https://www.npmjs.com/package/gulp-htmlmin
^ npm i gulp-htmlmin -D
или
^ npm install --save-dev gulp-htmlmin 
Usage
See the html-minifer docs for all available options.

const gulp = require('gulp');
const htmlmin = require('gulp-htmlmin'); //* 2 подключим
 
gulp.task('minify', () => { //* 3
  return gulp.src('src/*.html')
    .pipe(htmlmin({ collapseWhitespace: true }))
    .pipe(gulp.dest('dist'));
});
*/
//? 1 установим [gulp-htmlmin]
//^ [gulp-htmlmin]
//? 2 подключим
//^ [const htmlmin = require('gulp-htmlmin');]
//? 3 укажем task для минификации html

// Задача для минификации html
/* 
* БЫЛО в док-ии
gulp.task('minify', () => {
  return gulp.src('src/*.html')
    .pipe(htmlmin({ collapseWhitespace: true }))
    .pipe(gulp.dest('dist'));
});
 */
//* СТАЛО 1... 
// Задача(task) для минификации html
function html() {
  return gulp.src('src/*.html')
    .pipe(htmlmin({ collapseWhitespace: true }))
    .pipe(gulp.dest('dist'));
}

//? 4 укажем путь
// пути к изначальным файлам и файлу назначения
const paths = {
  html: {
    src: 'src/*.html', //* перенесем в папку[src] файл[index.html]
    dest: 'dist'
  },
}
//* ...СТАЛО 2 окончат 
// Задача(task) для минификации html
function html() {
  return gulp.src(paths.html.src)
    .pipe(htmlmin({ collapseWhitespace: true }))
    .pipe(gulp.dest(paths.html.dest));
}

//? 5 экспортируем task

const build = gulp.series(clean, html, gulp.parallel(styles, scripts, img), watch) //* 2 указали последовательно[html] (а уже после этого будем обрабатывать стили, скрипты и изображения)

exports.clean = clean
exports.img = img
exports.html = html //* 1 экспортируем task[html()]
exports.styles = styles
exports.scripts = scripts
exports.watch = watch
exports.build = build
exports.default = build
//? 6 запустим [gulp]
//~ видим, что все отработало и появился файл[index.html] в папке[dist]
//? [dist\index.html]
/* 
<!DOCTYPE html>
<html lang="ru">

	<head>
		<meta charset="UTF-8">
		<meta
			name="viewport"
			content="width=device-width,initial-scale=1"
		>
		<link
			rel="stylesheet"
			href="dist/css/main.min.css"
		>
		<title>Project Name</title>
	</head>

	<body>
		<p>Hello World</p>
		<script src="dist/js/main.min.js"></script>
	</body>

</html>
 */
-----------------------------

//!---16--- Шаблонизатор [pug] ---------
//^ [gulp-pug] плагин ---------
/* 
https://www.npmjs.com/package/gulp-pug
 [npm i gulp-pug -D] //* 1 установим
Usage
const { src, dest } = require('gulp');
const pug = require('gulp-pug'); //* 2 подключим

exports.views = () => {
  return src('./src/*.pug')
    .pipe(
      pug({
        // Your options in here.
      })
    )
    .pipe(dest('./dist'));
};
*/
//^  [gulp-pug] плагин
//? 1 установим [gulp-pug] плагин
//^ npm i gulp-pug -D

//? 2 подключим [gulp-pug] плагин
//^ const gulppug = require('gulp-pug');

//? 3 запустим pug()

// Задача для pug
function pug() {
  return gulp.src(paths.pug.src)
    .pipe(gulppug())
    .pipe(size({
      showFiles: true
    }))
    .pipe(gulp.dest(paths.pug.dest))
    .pipe(browserSync.stream())
}

//? 4 путь
// пути к изначальным файлам и файлу назначения
const paths = {
  pug: {
    src: 'src/*.pug',
    dest: 'dist/'
  }
}

//? 5 вызовем его отдельно, терминал:
//^ gulp pug
//? 5.1 создадим файл[src\second.pug]
//? 5.2 поместим в него код
/*  из док-ии возьмем код примера
https://pugjs.org/language/tags.html

ul
  li Item A
  li Item B
  li Item C
-------------
и добавим неск эл-в
doctype html
*/
doctype html
ul
  li Item A
  li Item B
  li Item C
//? 5.3 запустим
/* 
$ gulp pug
[17:26:31] Using gulpfile ~\Desktop\myTestGulp\gulpfile.js
[17:26:31] Starting 'pug'...
[17:26:31] second.html 69 B
[17:26:31] Finished 'pug' after 83 ms
*/
//? 6 получим [dist\second.html]

<!DOCTYPE html><ul><li>Item A</li><li>Item B</li><li>Item C</li></ul>
/* 
<!DOCTYPE html>
<ul>
	<li>Item A</li>
	<li>Item B</li>
	<li>Item C</li>
</ul> 
*/
------------------------------

//!---18--- CSS  препроцессор[Sass]  ---------
//^ [gulp-sass] плагин

