/*global module:false*/
module.exports = function(grunt) {
	var pkg = grunt.file.readJSON('package.json');
  // Project configuration.
  grunt.initConfig({
    meta: {
			version: '0.3.0',
			project: 'Test',
			website: 'http://vea.re',
			dev_name: 'Lukas',
    },
		
    // Metadata.
    banner: '/*! <%= meta.project %> - v<%= meta.version %> - ' +
      '<%= grunt.template.today("yyyy-mm-dd") %>\n' +
      '* <%= meta.website %>\n' +
      '* Copyright (c) <%= grunt.template.today("yyyy") %> ' +
      '<%= meta.dev_name %>; Licensed MIT */\n',

		
    // Task configuration.
    concat: {
      options: {
        banner: '<%= banner %>',
        stripBanners: true
      },
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
	      src: 'libs/css/*.css' // -> src/css/file1.css, src/css/file2.css
	      // dest: 'dest/css/' // -> dest/css/file1.css, dest/css/file2.css
	    },
	  },
		csslint: {
      lax: {
        options: {
					'import': 2,
					'box-sizing': false,
					'outline-none': false,
					'ids': false,
					'adjoining-classes': false,
					'box-model': false,
					'fallback-colors': false,
					'compatible-vendor-prefixes': false
        },
        src: ['libs/css/*.css']
			},
		},
    jshint: {
      options: {
        curly: true,
        eqeqeq: true,
        immed: true,
        latedef: true,
        newcap: true,
        noarg: true,
        sub: true,
        undef: true,
        unused: true,
        boss: true,
        eqnull: true,
        browser: true,
        globals: {
          jQuery: true
        }
      },
      // gruntfile: {
      //   src: 'Gruntfile.js'
      // },
      lib_test: {
        src: ['libs/**/*.js', 'test/**/*.js']
      }
    },
    qunit: {
      files: ['test/**/*_test.js']
    },
		svgsprite: {
			spriteCSS: {
			  src: 'layout/icons/',
			  dest: 'layout',
				options: {
			        render: {
			          css: {
		
						}
			        },
					common: 'icon',
			        maxwidth: 50,
			        maxheight: 50,
			        padding: 10,
					sprite: 'svg-icon-sprite',
					spritedir: '',
			        keep: false,
			        dims: false,
					cleanwith: 'NULL'
			      }
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
    watch: {
      gruntfile: {
        files: '<%= jshint.gruntfile.src %>',
        tasks: ['jshint:gruntfile']
      },
      lib_test: {
        files: '<%= jshint.lib_test.src %>',
        tasks: ['jshint:lib_test']
      },
		  svg_sprite: {
		    files: ['layout/**/*.svg'],
		    tasks: ['svgstore'],
			}
    }
  });

  // These plugins provide necessary tasks.
  grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	// https://www.npmjs.org/package/grunt-contrib-imagemin
	grunt.loadNpmTasks('grunt-contrib-imagemin');
  grunt.loadNpmTasks('grunt-contrib-uglify');
	
  grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-csslint');
  grunt.loadNpmTasks('grunt-contrib-watch');
	//https://www.npmjs.org/package/grunt-autoprefixer
	grunt.loadNpmTasks('grunt-autoprefixer');
	grunt.loadNpmTasks('grunt-svg-sprite');
	grunt.loadNpmTasks('grunt-svgstore');
  // Default task.
	grunt.registerTask('default', ['jshint', 'csslint', 'autoprefixer']);
  // Build task.
	grunt.registerTask('build', ['jshint', 'csslint', 'autoprefixer', 'concat', 'uglify', 'cssmin']);

};
