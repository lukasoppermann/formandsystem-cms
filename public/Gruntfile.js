/*global module:false*/
module.exports = function(grunt) {
	var pkg = grunt.file.readJSON('package.json');
  // Project configuration.
  grunt.initConfig({
		config: {
			layout: 'layout',
			images: 'images',
			css: 'css',
			js: 'js',
			bower_path: 'bower_components'
		},
    // Task configuration.
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
		imagemin: {
      dynamic: {
	      options: {
	        optimizationLevel: 3
	      },
        files: [{
          expand: true,
          cwd: 'layout',             // Src matches are relative to this path
          src: ['*.{png,jpg,gif}'],   // Actual patterns to match
          dest: 'layout'   // Destination path prefix
        }]
      }
		},
    autoprefixer: {
      options: {
        browsers: ['last 4 version', 'ie 8', 'ie 9']
      },
	    multiple_files: {
	      expand: true,
	      flatten: true,
	      src: '<%= config.css %>/*.css', // -> src/css/file1.css, src/css/file2.css
	      dest: '<%= config.css %>/' // -> dest/css/file1.css, dest/css/file2.css
	    }
	  },
		svgstore: {
	    options: {
	      prefix : 'icon-', // This will prefix each ID
	      svg: { // will be added as attributes to the resulting SVG
					id: 'svg_sprite',
					style: 'display: none;'
	      },
			  formatting : {
					indent_size : 2
				}
	    },
	    default : {
	      files: {
	        'layout/svg-sprite.svg': ['layout/icons/*.svg'],
	      },
	    },
	  },
	  jshint: {
	    all: ['Gruntfile.js']
	  },
		watch: {
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
				tasks: ['autoprefixer']
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
  // Default task.
	grunt.registerTask('default', ['autoprefixer','svgstore']);
  // Build task.
	grunt.registerTask('build', ['autoprefixer', 'concat', 'uglify', 'cssmin']);

};
