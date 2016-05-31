var elixir = require('laravel-elixir');
var gulp = require('gulp');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */


gulp.task("copyfiles", function() {


  gulp.src("bower_components/angular-ui-notification/dist/angular-ui-notification.js")
      .pipe(gulp.dest("resources/assets/js/"));



  gulp.src("bower_components/angular-ui-notification/dist/angular-ui-notification.css")
    .pipe(gulp.dest("resources/assets/sass/"))
});



elixir(function(mix) {


    mix.sass('app.scss')
      .scripts([
          'app.js',
          'angular-ui-notification.js']
      )

      .version(['css/app.css','js/all.js']);
});

