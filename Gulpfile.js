var gulp       = require('gulp'),
		annotate   = require('gulp-ng-annotate'),
		changed    = require('gulp-changed'),
		concat     = require('gulp-concat'),
		cssmin     = require('gulp-cssmin'),
		copy       = require('gulp-copy'),
		livereload = require('gulp-livereload'),
		plumber    = require('gulp-plumber'),
		prefix     = require('gulp-autoprefixer'),
		rename     = require('gulp-rename'),
		sass       = require('gulp-sass'),
		sourcemaps = require('gulp-sourcemaps'),
		uglify     = require('gulp-uglify');

var config = {
	"paths"  : {
		"original": {
			"css"  : "resources/assets/sass",
			"js"   : "resources/assets/js",
			"views": "resources/views"
		},
		"compiled": {
			"css"  : "public/builds/css",
			"fonts": "public/builds/fonts",
			"js"   : "public/builds/js"
		}
	},
	"fonts": [
		"public/components/bootswatch/fonts/*",
	],
	"styles" : [
		"public/components/bootswatch/flatly/bootstrap.css",
		"resources/assets/sass/**/*.scss"
	],
	"scripts": [
		"public/components/jquery/dist/jquery.js",
		"public/components/angular/angular.js",
		"public/components/bootstrap/dist/js/bootstrap.js",
		"public/components/jquery.tablesorter/js/jquery.tablesorter.js",
		"resources/assets/js/**/*.js"
	]
};

// Configuration
//////////////////////////////////////////////////////////////////////

gulp.task('css', function () {
	gulp.src(config.fonts)
		.pipe(copy(config.paths.compiled.fonts, {prefix: 4}));

	return gulp.src(config.styles)
		.pipe(plumber())
		.pipe(changed(config.paths.compiled.css))
		.pipe(sass())
		.pipe(prefix())
		.pipe(sourcemaps.init())
		.pipe(concat('styles.css'))
		.pipe(sourcemaps.write())
		.pipe(gulp.dest(config.paths.compiled.css))
		.pipe(livereload());
});

gulp.task('js', function () {
	return gulp.src(config.scripts)
		.pipe(plumber())
		.pipe(changed(config.paths.compiled.js))
		.pipe(sourcemaps.init())
		.pipe(annotate())
		.pipe(concat('scripts.js'))
		.pipe(sourcemaps.write())
		.pipe(gulp.dest(config.paths.compiled.js))
		.pipe(livereload());
});

gulp.task('minify', function () {
	gulp.src(config.paths.compiled.css + '/styles.css')
		.pipe(plumber())
		.pipe(cssmin())
		.pipe(rename({suffix: '.min'}))
		.pipe(gulp.dest(config.paths.compiled.css));

	gulp.src(config.paths.compiled.js + '/scripts.js')
		.pipe(plumber())
		.pipe(uglify())
		.pipe(rename({suffix: '.min'}))
		.pipe(gulp.dest(config.paths.compiled.js));
});

// Tasks
//////////////////////////////////////////////////////////////////////

gulp.task('default', ['css', 'js']);

gulp.task('watch', function () {
	livereload.listen();

	gulp.watch(config.paths.original.css + '/**/*.scss', ['css']);
	gulp.watch(config.paths.original.js + '/**/*.js', ['js']);
	gulp.watch(config.paths.original.views + '/**/*.twig', function () {
		livereload.reload('index.php');
	});
});
