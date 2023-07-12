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
git push -u origin main
*/