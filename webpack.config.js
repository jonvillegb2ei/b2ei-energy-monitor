/**
 * As our first step, we'll pull in the user's webpack.mix.js
 * file. Based on what the user requests in that file,
 * a generic config object will be constructed for us.
 */
let mix = require('./node_modules/laravel-mix/src/index');
let path = require('path');
let ComponentFactory = require('./node_modules/laravel-mix/src/components/ComponentFactory');

new ComponentFactory().installAll();

require(Mix.paths.mix());

/**
 * Just in case the user needs to hook into this point
 * in the build process, we'll make an announcement.
 */

Mix.dispatch('init', Mix);

/**
 * Now that we know which build tasks are required by the
 * user, we can dynamically create a configuration object
 * for Webpack. And that's all there is to it. Simple!
 */

let webpack = require('webpack');

let webpackDefaultConfig = require('./node_modules/laravel-mix/src/builder/webpack-default');
let Entry = require('./node_modules/laravel-mix/src/builder/Entry');
let webpackRules = require('./node_modules/laravel-mix/src/builder/webpack-rules');
let webpackPlugins = require('./node_modules/laravel-mix/src/builder/webpack-plugins');

process.noDeprecation = true;

class WebpackConfig {
    /**
     * Create a new instance.
     */
    constructor() {
        this.webpackConfig = webpackDefaultConfig();
    }

    /**
     * Build the Webpack configuration object.
     */
    build() {
        this.buildEntry()
            .buildOutput()
            .buildRules()
            .buildPlugins()
            .buildResolving()
            .mergeCustomConfig();

        Mix.dispatch('configReady', this.webpackConfig);

        return this.webpackConfig;
    }

    /**
     * Build the entry object.
     */
    buildEntry() {
        let entry = new Entry();

        if (! Mix.bundlingJavaScript) {
            entry.addDefault();
        }

        Mix.dispatch('loading-entry', entry);

        this.webpackConfig.entry = entry.get();

        return this;
    }

    /**
     * Build the output object.
     */
    buildOutput() {
        let http = process.argv.includes('--https') ? 'https' : 'http';

        if (Mix.isUsing('hmr')) {
            this.webpackConfig.devServer.host = Config.hmrOptions.host;
            this.webpackConfig.devServer.port = Config.hmrOptions.port;
        }

        this.webpackConfig.output = {
            path: path.resolve(Mix.isUsing('hmr') ? '/' : Config.publicPath),
            filename: '[name].js',
            chunkFilename: '[name].js',
            publicPath: Mix.isUsing('hmr')
                ? http +
                '://' +
                Config.hmrOptions.host +
                ':' +
                Config.hmrOptions.port +
                '/'
                : ''
        };

        return this;
    }

    /**
     * Build the rules array.
     */
    buildRules() {
        this.webpackConfig.module.rules = this.webpackConfig.module.rules.concat(
            webpackRules()
        );

        Mix.dispatch('loading-rules', this.webpackConfig.module.rules);

        return this;
    }

    /**
     * Build the plugins array.
     */
    buildPlugins() {
        this.webpackConfig.plugins = this.webpackConfig.plugins.concat(
            webpackPlugins()
        );

        Mix.dispatch('loading-plugins', this.webpackConfig.plugins);

        return this;
    }

    /**
     * Build the resolve object.
     */
    buildResolving() {
        this.webpackConfig.resolve = {
            extensions: ['*', '.js', '.jsx', '.vue'],

            alias: {
                'jquery': path.join(__dirname, 'node_modules/jquery/src/jquery')
            }
        };

        return this;
    }

    /**
     * Merge the user's custom Webpack configuration.
     */
    mergeCustomConfig() {
        if (Config.webpackConfig) {
            this.webpackConfig = require('webpack-merge').smart(
                this.webpackConfig,
                Config.webpackConfig
            );
        }
    }
}


module.exports = new WebpackConfig().build();
