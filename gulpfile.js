// Get modules
var gulp = require('gulp');
var autoprefixer = require('gulp-autoprefixer');
var concat = require('gulp-concat');
var imagemin = require('gulp-imagemin');
var pngcrush = require('imagemin-pngcrush');
var minifycss = require('gulp-minify-css');
var uglify = require('gulp-uglify');
var es = require('event-stream');
var sass = require('gulp-sass');
var csslint = require('gulp-csslint');
var browserSync = require('browser-sync');

var base_path = 'resources/assets/';
var build_path = 'public_html/';

// Configure the proxy server for livereload
var proxyServer = "http://examiner.dev:80",
    port = 3000;

// Array of files to watch
var arrAddFiles = [
    //build_path+'*'
];

// browser-sync task for starting the server.
gulp.task('browser-sync', function () {
    browserSync({
        proxy: proxyServer,
        port: port,
        files: arrAddFiles,
        ghostMode: {
            clicks: true,
            location: true,
            forms: true,
            scroll: true
        },
        notify: false,
        open: false
    });
});


// Task css
gulp.task('css', function () {
 var mainCss = gulp.src(base_path + 'css/style.scss')
     .pipe(sass().on('error', sass.logError))
     .pipe(csslint.reporter())
     .pipe(concat('base.min.css'))
     .pipe(autoprefixer('last 3 version'))
     .pipe(minifycss())
     .pipe(gulp.dest(build_path + 'css/'))
     .pipe(browserSync.reload({stream: true}));


});

// Task js
gulp.task('js', function () {
 return gulp.src([base_path + 'js/plugins/*.js', base_path + 'js/*.js'])
     .pipe(concat('main.min.js'))
     .pipe(uglify())
     .pipe(gulp.dest(build_path + 'js/'))
     .pipe(browserSync.reload({stream: true}));
});

//Task images
/*gulp.task('images', function () {
 return gulp.src(base_path + 'img/!**')
     .pipe(imagemin({
      progressive: true
     }))
     .pipe(gulp.dest(build_path + 'img/'))
     .pipe(browserSync.reload({stream: true}));
});*/

gulp.task('watch', function () {

 gulp.watch(base_path + 'css/**', ['css']);
 gulp.watch(base_path + 'js/**', ['js']);
 //gulp.watch(base_path + 'img/**', ['images']);

});

// The default task (called when you run `gulp` from cli)
gulp.task('default', ['browser-sync', 'css', 'js', 'watch']);

// Task when ready for production
gulp.task('production', ['css', 'js']);