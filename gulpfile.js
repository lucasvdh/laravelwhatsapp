const elixir = require('laravel-elixir');

require('laravel-elixir-vue');

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

elixir(function(mix) {
  // Compile all sass files into one
  mix.sass('laravel-macros.scss', 'resources/assets/css');

  // Compile individual sass files
  mix.sass('chosen.scss', 'resources/assets/css');
  mix.sass('datepicker.scss', 'resources/assets/css');
  mix.sass('license-plate.scss', 'resources/assets/css');
  mix.sass('material-checkbox.scss', 'resources/assets/css');
  mix.sass('material-radio.scss', 'resources/assets/css');
  mix.sass('tags-input.scss', 'resources/assets/css');

  // Compile all scripts into one
  mix.scripts([
    'jquery.inputmask.min.js',
    'chosen.jquery.min.js',
    'tags-input.js',
    'bootstrap-datepicker.js',
    'laravel-macros-app.js'
  ], 'resources/assets/js/laravel-macros.js');
});