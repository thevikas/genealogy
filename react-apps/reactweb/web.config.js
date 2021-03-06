var webpack = require('webpack');
var path = require('path');
const ExtractTextPlugin = require("extract-text-webpack-plugin");
var BUILD_DIR = path.resolve(__dirname, 'public/');
var APP_DIR = path.resolve(__dirname, 'src');
var production= false;

var config = {
    entry: APP_DIR + '/../../GeneReactNative/src/geneweb/index.js',
    output: {
        path: BUILD_DIR,
        filename: 'js/bundle.js'
    },
    devServer: {
        disableHostCheck: true,
        inline: true,
        publicPath: "/",
        contentBase: "./public",
        historyApiFallback: true,
    },
    module: {
        loaders: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                loader: "babel-loader"
            },
            {
               test: /\.exec\.js$/,
               use: [ 'script-loader' ]
       },
            /*{
                test: /\.(eot|woff|woff2|ttf|svg|png|jpg)$/,
                loader: 'url-loader?limit=30000&name=[name]-[hash].[ext]'
            },*/
            {
                test: /\.woff(2)?(\?v=[0-9]\.[0-9]\.[0-9])?$/,
                loader: 'url-loader?limit=10000&mimetype=application/font-woff'
              },
              { test: /\.json$/, loader: 'json-loader' },
            {
                test: /\.(ttf|eot|svg)(\?v=[0-9]\.[0-9]\.[0-9])?$/,
                loader: 'file-loader'
            },
            {
                test: /\.css$/,
                use: [ 'style-loader', 'css-loader' ]
              }
        ]
    },
    plugins: !production ?
        [
            new ExtractTextPlugin({
              filename: '[name].bundle.css',
              allChunks: true,
            }),
        ] :
        [
            new webpack.BannerPlugin("Copyright Pronity LLC"),
            new ExtractTextPlugin("styles.css"),
            new webpack.optimize.UglifyJsPlugin({
                minimize: true,
                compress: false
            })
        ],
    resolve: {
        modules: [__dirname, 'node_modules'],
        alias: {
            root: __dirname,
            APIConfig: path.resolve(__dirname,'config.class.apiphp.jsx'),
            RouteURLMaker: path.resolve(__dirname,'route.url.maker.jsx'),
            pubjs: path.resolve(__dirname, 'public/js'),
            pubcss: path.resolve(__dirname, 'public/css'),
            libs: path.resolve(__dirname, '../GeneReactNative/src/libs'),
            store: path.resolve(__dirname, '../GeneReactNative/src/store'),
            helperfunctions: path.resolve(__dirname, '../GeneReactNative/src/store/helperfunctions.js'),
            constants: path.resolve(__dirname, '../GeneReactNative/src/constants'),
            webcontainers: path.resolve(__dirname, '../GeneReactNative/src/geneweb/containers'),
            webcomponents: path.resolve(__dirname, '../GeneReactNative/src/geneweb/components'),
        },
        extensions: ['.js', '.jsx' ]
    },
};

module.exports = config;
