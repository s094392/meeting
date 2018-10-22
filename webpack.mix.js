const mix = require('laravel-mix');

const BASE_PATH = '/';
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

mix.setResourceRoot(BASE_PATH);

mix.js('resources/assets/js/app.js', 'public/js')
  .extract([
    'vue',
    'uikit',
    'uikit/dist/js/uikit-icons',
    'axios',
    'vue-router',
    'mavon-editor',
    'vuex',
    'moment',
    'vue-multiselect',
    'flatpickr'])
  .sass('resources/assets/sass/app.scss', 'public/css');

// const { BundleAnalyzerPlugin } = require('webpack-bundle-analyzer');
const webpack = require('webpack');

mix.webpackConfig({
  output: {
    publicPath: BASE_PATH,
  },
  plugins: [
    // new BundleAnalyzerPlugin(),
    new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/),
  ],
});
