var gulp = require("gulp");

var resources = {
	'angular': './bower_components/angularjs/angular.js',
	'css': './src/style/*.css',
	'js': './src/js/*.js',
	'docs': './src/*.{php,html}'
};

gulp.task('default', ['copy', 'watch']);

// Copy statics
gulp.task('copy', function() {
	// Angular
	gulp.src(resources.angular)
	.pipe(gulp.dest('./dist/js/angularjs'));

	// All CSS-files
	gulp.src(resources.css)
	.pipe(gulp.dest('./dist/style'));

	// Our js
	gulp.src(resources.js)
	.pipe(gulp.dest('./dist/js'));

	// Our php/html
	gulp.src(resources.docs)
	.pipe(gulp.dest('./dist'));	
});

gulp.task('watch', function() {
	var watcher = gulp.watch('./src/**/*.*', ['copy']);

	watcher.on('change', function(event) {
	  console.log('File ' + event.path + ' was ' + event.type + ', running tasks...');
	});
});
