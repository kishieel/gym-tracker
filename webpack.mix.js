const mix = require('laravel-mix');
const path = require('path');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.webpackConfig({
    resolve: {
        extensions: ["*", ".ts"],
        alias: {
            "@src": path.join(__dirname, "resources/js/"),
        }
    },
})

mix.ts('resources/js/register-service-workers.ts', 'public/js')
    .ts('resources/js/web-push-service-worker.ts', 'public/js')
    .minify('public/js/register-service-workers.js', 'public/js/register-service-workers.min.js')
    .minify('public/js/web-push-service-worker.js', 'public/js/web-push-service-worker.min.js');
