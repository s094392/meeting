const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/js')
  .extract(['vue', 'uikit', 'axios', 'vue-router',
    'vuex', 'markdown-it', 'uikit/dist/js/uikit-icons', 'moment', 'vue-multiselect', 'flatpickr'])
  .sass('resources/assets/sass/app.scss', 'public/css');

mix.copy('node_modules/easymde/dist/easymde.min.css', 'public/css/easymde.min.css');

mix.copy('node_modules/@fortawesome/fontawesome-free/css/solid.min.css', 'public/css/solid.min.css');
mix.copy('node_modules/@fortawesome/fontawesome-free/css/fontawesome.min.css', 'public/css/fontawesome.min.css');
mix.copy('node_modules/@fortawesome/fontawesome-free/webfonts/fa-solid-*', 'public/webfonts');


// const { BundleAnalyzerPlugin } = require('webpack-bundle-analyzer');
const webpack = require('webpack');

mix.webpackConfig({
  plugins: [
    // new BundleAnalyzerPlugin(),
    new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/),
  ],
});
