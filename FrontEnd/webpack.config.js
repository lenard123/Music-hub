'use strict'

const { VueLoaderPlugin } = require('vue-loader')
const HtmlWebpackPlugin = require('html-webpack-plugin')
const CleanWebpackPlugin = require('clean-webpack-plugin')

const path = require('path')

module.exports = {
	mode: 'production',
	entry: './src/js/app.js',
	output: {
		filename: 'app.js',
		path: path.resolve(__dirname, 'dist')
	},
	devtool: 'inline-source-map',
	module: {
		rules: [
			{
				test: /\.js$/,
				exclude: /node_modules/,
				use: {
					loader: 'babel-loader',
					options: {
						presets: ['@babel/preset-env']
					}
				}
			},

			{
				test: /\.vue$/,
				use: 'vue-loader'
			},

			{
				test: /\.css$/,
				use: [
					'vue-style-loader',
					'css-loader'
				]
			},

			{
				test:/\.(png|svg|jpg|gif)$/,
				use: [
					'file-loader'
				]
			},

			{
				test: /\.(woff|woff2|eot|ttf|otf)$/,
				use: [
					'file-loader'
				]
			}
		]
	},

	plugins: [
		new VueLoaderPlugin(),
		new HtmlWebpackPlugin({template:'src/index.html'}),
		new CleanWebpackPlugin(['dist'])
	]
}