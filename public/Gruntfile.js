/*global module:false*/
module.exports = function (grunt) {

  // Project configuration.
  grunt.initConfig({
    // Metadata.
    pkg: grunt.file.readJSON('package.json'),

    sass: {
      options: {
        includePaths: ['bower_components/scss']
      },
      dist: {
        options: {
          outputStyle: 'compressed'
        },
        files: {
          'css/main/app.css': 'scss/app.scss'
        }
      }
    },

    copy: {
      scripts: {
        expand: true,
        cwd: 'bower_components/',
        src: '**/*.js',
        dest: 'js/main'
      },

      maps: {
        expand: true,
        cwd: 'bower_components/',
        src: '**/*.map',
        dest: 'js/main'
      }
    },

    // Task configuration.
    concat: {
      options: {
        separator: ';'
      },
      dist: {
        options: {
          outputStyle: 'compressed'
        },
        src: [
          'js/main/foundation.min.js',
          'js/main/jquery-ui.min.js',
          'js/main/angular/angular.min.js',
          // 'js/jquery-ui.structure.min.js',
          'js/main/js.cookie.js',
          'js/main/jeditable.min.js',
          'js/main/pace.min.js',
          // 'js/main/tooltip.js',
          // 'js/main/init.js'
        ],

        dest: 'js/main/app.js'
      }

    },

    uglify: {
      dist: {
        files: {
          'js/modernizr/modernizr.min.js': ['js/modernizr/modernizr.js']
        }
      }
    },

    watch: {
      grunt: { files: ['Gruntfile.js'] },
      scripts: {
        files: [
            'js/main/profiles.js',
            'js/main/init.js'
        ],
        tasks: ['concat']
      },

      sass: {
        files: 'scss/**/*.scss',
        tasks: ['sass']
      }
    }
  });

  // These plugins provide necessary tasks.
  grunt.loadNpmTasks('grunt-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-modernizr');

  // Default task.
  grunt.registerTask('build', ['sass']);
  grunt.registerTask('default', ['copy', 'uglify', 'concat', 'watch']);

};