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


  //Angular UI notification
  // gulp.src("bower_components/angular-ui-notification/dist/angular-ui-notification.js")
  //     .pipe(gulp.dest("resources/assets/js/"));
  //
  //
  //
  // gulp.src("bower_components/angular-ui-notification/dist/angular-ui-notification.css")
  //   .pipe(gulp.dest("resources/assets/sass/"))

  gulp.src("bower_components/angular-animate/angular-animate.js")
    .pipe(gulp.dest("resources/assets/js/"));

  gulp.src("bower_components/angular-sanitize/angular-sanitize.js")
    .pipe(gulp.dest("resources/assets/js/"));

  gulp.src("bower_components/ngToast/dist/ngToast.js")
    .pipe(gulp.dest("resources/assets/js/"));

  gulp.src("bower_components/angular-modal-service/dst/angular-modal-service.js")
    .pipe(gulp.dest("resources/assets/js/"));

  gulp.src("bower_components/angular-bootstrap/ui-bootstrap.js")
    .pipe(gulp.dest("resources/assets/js/"));




  gulp.src("bower_components/ngToast/dist/ngToast.css")
    .pipe(gulp.dest("resources/assets/sass/"));

  gulp.src("bower_components/ngToast/dist/ngToast-animations.css")
    .pipe(gulp.dest("resources/assets/sass/"));

  gulp.src("resources/assets/bg/1.jpg")
    .pipe(gulp.dest("public/build/bg"));
});




elixir(function(mix) {


    mix.sass('app.scss')
      // .scripts([
      //     'app.js',
      //     'angular-ui-notification.js']
      // )

      .scripts([
        'app.js',
        'angular-animate.js',
        'angular-sanitize.js',
        'ngToast.js',
        'ui-bootstrap.js',
        'angular-modal-service.js']
      )

      .version(['css/app.css','js/all.js']);
});

