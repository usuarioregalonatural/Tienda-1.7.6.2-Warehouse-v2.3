var webpack = require('webpack');
var path = require('path');
var ExtractTextPlugin = require("extract-text-webpack-plugin");
var plugins = [];
var production = false;

if (production) {
    plugins.push(
        new webpack.optimize.UglifyJsPlugin({
            compress: {
                warnings: false
            }
        })
    );
}

plugins.push(
    new ExtractTextPlugin(
        path.join(
            '..', 'css', '[name].css'
        )
    )
);

module.exports = {
    entry: {admin_tab: './admin/index.js', front: './front/index.js'},
    output: {
        path: '../js',
        filename: '[name].js'
    },
    module: {
        loaders: [{
            test: /\.js$/,
            exclude: /node_modules/,
            loaders: ['babel-loader']
        }, {
            test: /\.scss$/,
            loader: ExtractTextPlugin.extract(
                "style",
                "css?sourceMap!postcss!sass?sourceMap"
            )
        }, {
            test: /.(png|woff(2)?|eot|ttf|svg)(\?[a-z0-9=\.]+)?$/,
            loader: 'file-loader?name=../css/[hash].[ext]'
        }, {
            test: /\.css$/,
            loader: "style-loader!css-loader!postcss-loader"
        }]
    },
    postcss: function() {
        return [require('postcss-flexibility')];
    },
    devtool: 'source-map',
    plugins: plugins,
    resolve: {
        extensions: ['', '.js', '.scss']
    }
};
