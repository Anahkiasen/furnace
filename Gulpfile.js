var gulp     = require('gulp'),
		gulpLoadPlugins = require('gulp-load-plugins'),
		plugins  = gulpLoadPlugins({
			rename: {
				'gulp-ng-annotate'  : 'annotate',
				'gulp-autoprefixer': 'prefix',
			}
		});

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
	"fonts"  : [
		"public/components/bootswatch/fonts/*",
	],
	"styles" : [
		"public/components/bootswatch/flatly/bootstrap.css",
		'public/components/selectize/dist/css/selectize.bootstrap3.css',
		"resources/assets/sass/**/*.scss"
	],
	"scripts": [
		"public/components/jquery/dist/jquery.js",
		"public/components/angular/angular.js",
		'public/components/microplugin/src/microplugin.js',
		'public/components/selectize/dist/js/standalone/selectize.js',
		"public/components/bootstrap/dist/js/bootstrap.js",
		"public/components/jquery.tablesorter/js/jquery.tablesorter.js",
		"resources/assets/js/**/*.js"
	]
};

// Configuration
//////////////////////////////////////////////////////////////////////

gulp.task('css', function () {
	gulp.src(config.fonts)
		.pipe(plugins.copy(config.paths.compiled.fonts, {prefix: 4}));

	return gulp.src(config.styles)
		.pipe(plugins.plumber())
		.pipe(plugins.changed(config.paths.compiled.css))
		.pipe(plugins.sass())
		.pipe(plugins.prefix())
		.pipe(plugins.sourcemaps.init())
		.pipe(plugins.concat('styles.css'))
		.pipe(plugins.sourcemaps.write())
		.pipe(gulp.dest(config.paths.compiled.css))
		.pipe(plugins.livereload());
});

gulp.task('js', function () {
	return gulp.src(config.scripts)
		.pipe(plugins.plumber())
		.pipe(plugins.changed(config.paths.compiled.js))
		.pipe(plugins.sourcemaps.init())
		.pipe(plugins.annotate())
		.pipe(plugins.concat('scripts.js'))
		.pipe(plugins.sourcemaps.write())
		.pipe(gulp.dest(config.paths.compiled.js))
		.pipe(plugins.livereload());
});

gulp.task('minify', function () {
	gulp.src(config.paths.compiled.css + '/styles.css')
		.pipe(plugins.plumber())
		.pipe(plugins.cssmin())
		.pipe(plugins.rename({suffix: '.min'}))
		.pipe(gulp.dest(config.paths.compiled.css));

	gulp.src(config.paths.compiled.js + '/scripts.js')
		.pipe(plugins.plumber())
		.pipe(plugins.uglify())
		.pipe(plugins.rename({suffix: '.min'}))
		.pipe(gulp.dest(config.paths.compiled.js));
});

// Tasks
//////////////////////////////////////////////////////////////////////

gulp.task('default', ['css', 'js']);

gulp.task('watch', function () {
	plugins.livereload.listen();

	gulp.watch(config.paths.original.css + '/**/*.scss', ['css']);
	gulp.watch(config.paths.original.js + '/**/*.js', ['js']);
	gulp.watch(config.paths.original.views + '/**/*.twig', function () {
		plugins.livereload.reload('index.php');
	});
});
