module.exports = function(gulp) {
  var path_os = require('path');
  var browserSync = require('browser-sync').create();
  var argv = require('yargs').argv;

  gulp.task('watch', function() {

    browserSync.init({
      startPath: '',
      proxy: "localhost:" + argv.port
    });


    gulp.watch('frontend/static/styles/**/*.styl', function(event) {
      var filepath = event.path;
      var relative_path = event.path.replace(gulp.config.dirname + "/static/styles/", "");

      if (
        relative_path.indexOf('modules' + path_os.sep) === -1 &&
        relative_path.indexOf('sections' + path_os.sep) === -1 &&
        relative_path.indexOf('libs' + path_os.sep) === -1
      ) {
        relative_path = event.path.replace(gulp.config.dirname + path_os.sep, "");
        gulp.config.stylesTask(relative_path, { cwd: 'frontend', base: 'frontend/static/styles' });
      } else {
        gulp.config.stylesTask( "*.styl", {
          cwd : 'frontend/static/styles'
        });
      }
    }).on('change', browserSync.reload);

    gulp.watch('frontend/templates/**/*.pug', function(event) {
      var filepath = event.path;
      var relative_path; //= event.path.replace(gulp.config.dirname + path_os.sep + "templates", "");
      var name = filepath.split('/').pop();


      if (/_(.*).pug/.test(name)) {
        gulp.config.pugTask([
        '*.pug',
        '**/*.pug',
        '!_layout.pug',
        '!**/_layout.pug',
        '!includes/**/*.pug',
        '!mixins/**/*.pug',
        '!_*.pug'
      ], {
          cwd : 'frontend/templates/modules'
        });
      } else {
        relative_path = event.path.replace(gulp.config.dirname + path_os.sep, "");
        gulp.config.pugTask(relative_path, { cwd: 'frontend', base : 'frontend/templates/modules'});
      }
    }).on('change', browserSync.reload);

  });
}
