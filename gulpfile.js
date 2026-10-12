const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const rename = require('gulp-rename');
const cssmin = require('gulp-clean-css');
const terser = require('gulp-terser');
const htmin = require('gulp-htmlmin');
const maps = require('gulp-sourcemaps');


gulp.task('css', function() {
	gulp.src('src/styly/*.scss')
		.pipe(sass())
		.pipe(cssmin({compatibility: 'ie8'}))
		.pipe(gulp.dest('dist/styly'));
});

gulp.task('html', function() {
	gulp.src('src/html_header.php')
		.pipe(htmin({
			collapseWhitespace: true
		}))
		.pipe(gulp.dest('dist'));
});

gulp.task('js', function() {
	gulp.src('src/klient/*.js')
		.pipe(terser({
			keep_fnames: true,
			mangle: false
		}))
		.pipe(gulp.dest('dist/klient'));
});




 







