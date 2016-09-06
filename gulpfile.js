// Imports
var gulp = require('gulp');
var rename = require('gulp-rename');
var rev = require('gulp-rev');
var del = require('del');
var postcss = require('gulp-postcss');
var concat = require('gulp-concat');
var jsmin = require('gulp-jsmin');
var plumber = require('gulp-plumber');
var svgmin = require('gulp-svgmin');
var svgstore = require('gulp-svgstore');
var cheerio = require('gulp-cheerio');
var notify = require('gulp-notify');
var sourcemaps = require('gulp-sourcemaps');
var runSequence = require('run-sequence');
/* ------------------------------
 *
 * JS
 *
 */
gulp.task('clean-js', function(){
    return del([
        'public/build/js/app.js',
        'public/build/js/app.js.map',
        'public/build/js/app-*.js'
    ]);
});

gulp.task('build-js', function(){
    var files = [];
    // push prism stuff
    files.push(
        // npm stuff
        'node_modules/readyjs/dist/ready.js',
        'node_modules/unfocus/dist/unfocus.js',
        'node_modules/foreach.js/dist/foreach.js',
        'node_modules/isemptyjs/dist/isempty.js',
        // 'node_modules/es6-promise/dist/es6-promise.js',
        // 'node_modules/fetch/lib/fetch.js',
        // kill
        // 'resources/bower_components/html.sortable/dist/html.sortable.js',
        // 'resources/bower_components/codemirror/lib/codemirror.js',
        // 'resources/bower_components/codemirror/addon/mode/overlay.js',
        // 'resources/bower_components/codemirror/addon/display/placeholder.js',
        // 'resources/bower_components/codemirror/mode/markdown/markdown.js',
        // 'resources/bower_components/codemirror/mode/gfm/gfm.js',
        // 'resources/bower_components/sortable-elements/dist/sortable-elements.js',
        // 'resources/bower_components/mark/src/mark.src.js',
        // 'resources/js/input.js',
        // 'resources/js/autosubmit-form.js',
        // 'resources/js/ajax-spawn-form.js',
        // 'resources/js/dialog-colllection.js',
        // 'resources/js/sortable-fragments.js',
        // 'resources/js/sortable-navigation.js',
        'resources/js/toggle-dropdown.js',
        // Add APP
        'resources/js/app.js'
    );
    // BUILD JS
    return gulp.src(files)
        .pipe(sourcemaps.init())
        .pipe(concat('app.js'))
        .pipe(jsmin())
        .pipe(sourcemaps.write('/'))
        .pipe(gulp.dest('public/build/js'));
});
// js
gulp.task('js', function(done){
    runSequence(
        'clean-js',
        'build-js',
        'rev',
        done
    );
});
// watch js
gulp.task('watch-js', function(){
    gulp.watch([
        'resources/js/*'
    ], ['js']);
});
/* ------------------------------
 *
 * EXTERNAL JS
 *
 */
gulp.task('clean-external-js', function(){
    return del([
        'public/build/js/external.js',
        'public/build/js/external.js.map',
        'public/build/js/external-*.js'
    ]);
});
// BUILD
gulp.task('build-external-js', function(){
    var files = [];
    // push files
    files.push(
        'resources/js/input.js',
        'resources/js/external/*.js'
    );

    return gulp.src(files)
    .pipe(sourcemaps.init())
    .pipe(concat('external.js'))
    .pipe(jsmin())
    .pipe(sourcemaps.write('/'))
    .pipe(gulp.dest('public/build/js'));
});
// css
gulp.task('external-js', function(done){
    runSequence(
        'clean-external-js',
        'build-external-js',
        'rev',
        done
    );
});
// watch css
gulp.task('watch-external-js', function(){
    gulp.watch([
        'resources/js/external/*',
    ], ['css']);
});
/* ------------------------------
 *
 * POST CSS
 *
 */
 gulp.task('clean-css', function(done){
     return del([
         'public/build/css/app.css',
         'public/build/css/app.css.map',
         'public/build/css/app-*.css'
     ]);
 });

gulp.task('build-css', function(){
    return gulp.src([
            'resources/css/includes/*.css',
            'resources/css/*.css',
            'resources/css/pages/*.css',
            // npm resources
            'node_modules/minireset.css/minireset.css',
            'node_modules/flexboxgrid/css/flexboxgrid.css'
        ])
        .pipe(sourcemaps.init())
        .pipe(plumber({errorHandler: notify.onError("Error: <%= error.message %>")}))
        .pipe(concat('app.css'))
        .pipe(postcss([
            require("postcss-import")(),
            require("postcss-url")(),
            require('postcss-will-change'),
            require("cssnano")({
                autoprefixer: false,
                discardComments: {
                    removeAll: true
                },
                zindex: false
            }),
            require("postcss-cssnext")({
                browsers: ['last 2 versions']
            }),
            require("postcss-color-function"),
            require("postcss-reporter")({
                plugins: [
                    "postcss-color-function"
                ]
            }),
        ]))
        .pipe(sourcemaps.write('/'))
        .pipe(gulp.dest('public/build/css'));
});
// css
gulp.task('css', function(done){
    runSequence(
        'clean-css',
        'build-css',
        'rev',
        done
    );
});
// watch css
gulp.task('watch-css', function(){
    gulp.watch([
        'resources/css/*',
        'resources/css/**/*'
    ], ['css']);
});
/* ------------------------------
 *
 * SVG
 *
 */

gulp.task('clean-svg', function(done){
    return del([
        'public/build/svgs/svg-sprite.svg',
        'public/build/svgs/svg-sprite-*.svg'
    ]);
});

gulp.task('svgsprite', function() {
    // individual icons
    gulp.src('resources/svgs/*.svg')
    .pipe(cheerio({
        run: function ($) {
            $('path, rect').each(function(){
                $(this).addClass($(this).attr('id'));
            });
        }
    }))
    .pipe(svgmin({
        plugins: [{
            removeAttrs: {
                attrs: 'fill=[^url]*'
            }
        },
        {
             removeTitle: true
        },
        {
             removeDesc: true
        },
        {
            convertShapeToPath: false
        }]
    }))
    .pipe(gulp.dest('public/build/svgs'));
    // SPRITE
    return gulp.src('resources/svgs/*.svg')
    .pipe(svgmin({
        plugins: [{
            removeAttrs: {
                attrs: 'fill=[^url]*'
            }
        },
        {
             removeTitle: true
        },
        {
             removeDesc: true
        },
        {
            convertShapeToPath: false
        }]
    }))
    .pipe(rename({prefix: 'svg-icon--'}))
    .pipe(svgstore({inlineSvg: true }))
    .pipe(rename('svg-sprite.svg'))
    .pipe(cheerio({
        run: function ($) {
            $('svg').attr({ style: 'display:none' });
        }
    }))
    .pipe(gulp.dest('public/build/svgs'));
});
// svg
gulp.task('svg', function(done){
    runSequence(
        'clean-svg',
        'svgsprite',
        'rev',
        done
    );
});
// watch svgs
gulp.task('watch-svg', function(){
    gulp.watch([
        'resources/svgs/*'
    ], ['svg']);
});
/* ------------------------------
 *
 * Revision
 *
 */
gulp.task('rev', function(done){
    return gulp.src([
        'public/build/css/app.css',
        'public/build/js/app.js',
        'public/build/js/external.js',
        'public/build/svgs/svg-sprite.svg'
    ], {base: 'public/build'})
        .pipe(rev())
        .pipe(gulp.dest('public/build'))
        .pipe(rev.manifest({
			merge: true // merge with the existing manifest (if one exists)
		}))
        .pipe(gulp.dest('public/build'));
});
/* ------------------------------
 *
 * default task
 *
 */
gulp.task('default', function(done){
    runSequence(
[    'clean-js',
    'clean-css',
    'clean-external-js',
    'clean-svg'],
[    'build-js',
    'build-css',
    'build-external-js',
    'svgsprite'],
    'rev',
[    'watch-svg',
    'watch-css',
    'watch-js',
    'watch-external-js'],
    done
    );
});
