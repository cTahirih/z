var settings,
    config,
    gulp,
    argv;

argv = require('yargs').argv;
gulp = require('gulp');
config = require('./frontend/config.js');

require('gulp-simple-load-tasks')(gulp)
config.setEnv('prod');
settings = require('./frontend/settings/prod');

if (argv.dev) {
  config.setEnv('dev');
  settings = require('./frontend/settings/dev');
}

config.settings = settings;
gulp.config = config;
gulp.loadTasks(__dirname + '/frontend/tasks');
