module.exports = function(grunt) {
  require('jit-grunt')(grunt);

  grunt.initConfig({
    less: {
      development: {
        options: {
          compress: true,
          yuicompress: true,
          optimization: 2,
          sourceMap: true
        },
        files: [
          {
            src: "webroot/less/app/app.less",
            dest: "webroot/css/app.css"
          },
          {
            src: "webroot/less/admin-lte-custom/admin-lte-custom.less",
            dest: "webroot/css/admin-lte-custom.css"
          },
          {
            expand: true,
            cwd: 'webroot/vendors/bower_components/admin-lte/build/less/skins/',
            src: [
              '*.less',
              '!_all-skins.less'
            ],
            dest: 'webroot/css/skins/',
            ext: '.css'
          }
        ]
      }
    },
    watch: {
      styles: {
        files: ['webroot/less/**/*.less'], // which files to watch
        tasks: ['less'],
        options: {
          nospawn: false
        }
      }
    }
  });
  grunt.registerTask('compile', 'less');
  grunt.registerTask('default', ['less', 'watch']);
};