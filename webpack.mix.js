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
  .extract(['vue', 'uikit', 'uikit/dist/js/uikit-icons', 'axios', 'vue-router', 'mavon-editor',
    'vuex', 'moment', 'vue-multiselect', 'flatpickr'])
  .sass('resources/assets/sass/app.scss', 'public/css');

// const { BundleAnalyzerPlugin } = require('webpack-bundle-analyzer');
const webpack = require('webpack');

mix.webpackConfig({
  plugins: [
    // new BundleAnalyzerPlugin(),
    new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/),
  ],
});
