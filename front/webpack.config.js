var HtmlWebpackPlugin = require('html-webpack-plugin');
const path = require('path');

module.exports = {
    mode: 'development',
    resolve: {
        extensions: ['.js', '.jsx']
    },
    module: {
        rules: [
            {
                test: /\.jsx?$/,
                loader: 'babel-loader'
            },
            {
                test: /\.(sa|sc|c)ss$/,
                use: ['style-loader', 'css-loader', 'sass-loader'],
            },
            {
                test: /\.(png|jpe?g|gif|svg)$/,
                exclude: [/font/, /fonts/],
                loader: 'file-loader',
                options: {
                    name: './assets/images/[folder]/[name].[ext]',
                    publicPath: '../../',
                    /**
                     * Note: Assets are loaded from the same path as the generated CSS-files
                     *       Adjust publicPath{publicPath} accordingly if you change css paths
                     */
                },
            },
            {
                test: /\.(eot|svg|ttf|woff2?|otf)$/,
                exclude: [/img/, '/images/'],
                loader: 'file-loader',
                options: {
                    name: './assets/fonts/[folder]/[name].[ext]',
                    publicPath: '../../',
                    /**
                     * Note: Assets are loaded from the same path as the generated CSS-files
                     *       Adjust publicPath{publicPath} accordingly if you change css paths
                     */
                },
            },
        ]
    },
    resolve: {
        extensions: ['.js', '.jsx'],
        alias: {
            '@': path.resolve(__dirname, 'src/'),
        }
    },
    plugins: [new HtmlWebpackPlugin({
        template: './src/index.html'
    })],
    devServer: {
        historyApiFallback: true
    },
    externals: {
        // global app config object
        config: JSON.stringify({
            apiUrl: 'http://localhost:8099'
        })
    }
}