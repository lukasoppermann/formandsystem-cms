/*global module:false*/
/* MD5 module for node.js: https://github.com/pvorb/node-md5 */
// module exports
module.exports = function(grunt) {
	var md5 = require('MD5');
	var fs = require('fs');
	var calculateMD5String = function(path){
		fs.readFile(path, function(err, buf) {
  		return md5(buf);
		});
	}
	var pkg = grunt.file.readJSON('package.json');
	// Project configuration.
	grunt.initConfig({
		config: {
			layout: 'layout',
			images: 'images',
			css: 'css',
			js: 'js',
			mainjs: 'main.js',
			bower_path: 'bower_components'
		},
		// ----------------------------------------------
		// Task configuration.
 		//
		concat: {
			dist: {
				src: ['libs/js/*.js'],
				dest: 'libs/js/application.min.js'
			}
		},
		uglify: {
			options: {
				banner: '<%= banner %>'
			},
			dist: {
				src: '<%= concat.dist.dest %>',
				dest: 'dist/<%= pkg.name %>.min.js'
			}
		},
		cssmin: {
			minify: {
				expand: true,
				files: {
					'libs/css/application.min.css': ['libs/css/*.css', '!libs/css/*.min.css']
				}
			}
		},
		// ----------------------------------------------
		// imagemin
		//
		imagemin: {
			dynamic: {
				options: {
					optimizationLevel: 3
				},
				files: [{
					expand: true,
					cwd: 'layout', // Src matches are relative to this path
					src: ['*.{png,jpg,gif}'], // Actual patterns to match
					dest: 'layout' // Destination path prefix
				}]
			}
		},
		// ----------------------------------------------
		// requirejs
		//
		requirejs: {
			js: {
				options: {
					baseUrl: "<%= config.js %>/<%=bower_path%>",
					out: "<%=config.js%>/application"+calculateMD5String("<%=config.js%>/<%= config.mainjs %>")+'.min.js',
					name: 'main',
					optimize: 'none',
					mainConfigFile: '<%= config.js %>/<%= config.mainjs %>',
					useStrict: true,
					wrap: true
				}
			},
			css: {
				options: {
					optimizeCss: 'standard',
					cssIn: '<%= config.css %>/*.css',
					out: '<%= config.css %>application.min.css'
				}
			}
		},
		// ----------------------------------------------
		// autoprefixer
		//
		autoprefixer: {
			options: {
				browsers: ['last 4 version', 'ie 8', 'ie 9']
			},
			css_files: {
				src: '<%= config.css %>/*.css'
			},
			js_css: {
				src: '<%= config.js %>/**/**/*.css'
			}
		},
		// ----------------------------------------------
		// svgstore
		//
		svgstore: {
			options: {
				prefix : 'icon-', // This will prefix each ID
				svg: { // will be added as attributes to the resulting SVG
					id: 'svg_sprite',
					style: 'display: none;'
				},
				cleanup: true,
				formatting : {
					indent_size : 2
				}
			},
			default : {
				files: {
					'layout/svg-sprite.svg': ['layout/icons/*.svg'],
				}
			}
		},
		jshint: {
			all: ['Gruntfile.js']
		},
		// ----------------------------------------------
		// Watch tasks
		//
		watch: {
			options: {
				spawn: false // add spawn option in watch task
			},
			jshint: {
				files: ['Gruntfile.js'],
				tasks: ['jshint']
			},
			svgsprite: {
				files: ['layout/**/*.svg'],
				tasks: ['svgstore']
			},
			css: {
				files: ['<%= config.css %>/*.css','!<%= config.css %>/*.min.css'],
				tasks: ['autoprefixer:css_files']
			},
			js_css: {
				files: ['<%= config.js %>/**/**/*.css','!<%= config.css %>/*.min.css'],
				tasks: ['autoprefixer:js_css']
			}
		}
	});

	// These plugins provide necessary tasks.
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	// https://www.npmjs.org/package/grunt-contrib-imagemin
	grunt.loadNpmTasks('grunt-contrib-imagemin');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-replace');
	grunt.loadNpmTasks('grunt-shell');
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-watch');
	//https://www.npmjs.org/package/grunt-autoprefixer
	grunt.loadNpmTasks('grunt-autoprefixer');
	grunt.loadNpmTasks('grunt-svgstore');
	grunt.loadNpmTasks('grunt-contrib-requirejs');
	// Default task.
	grunt.registerTask('default', ['autoprefixer','svgstore']);
	// Build task.
	grunt.registerTask('build', ['autoprefixer', 'concat', 'uglify', 'cssmin']);

};
