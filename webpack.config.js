const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const FixStyleOnlyEntriesPlugin = require('webpack-fix-style-only-entries');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');

const outputDir = './build';
const entry = {
	'./js/app.admin': './src/admin/js/app.js',
	'./css/app': './src/scss/app.scss',
};

module.exports = (env) => {
	return [
		{
			entry: entry,
			output: {
				path: path.join(__dirname, outputDir),
				filename: '[name].js',
				publicPath: '/build/',
			},
			module: {
				rules: [
					{
						test: /\.js$/,
						use: 'babel-loader',
					},
					{
						test: /\.css$/i,
						use: [MiniCssExtractPlugin.loader, 'css-loader'],
					},
					{
						test: /\.scss$/i,
						use: [MiniCssExtractPlugin.loader, 'css-loader', 'sass-loader'],
					},
				],
			},
			plugins: [
				new FixStyleOnlyEntriesPlugin(),
				new MiniCssExtractPlugin({
					filename: '[name].css',
				}),
			],
			optimization: {
				minimizer: [new UglifyJsPlugin(), new CssMinimizerPlugin()],
			},
		},
	];
};
