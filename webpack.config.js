const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = {
  entry: {
    admin: './src/Admin/index.js',   // Entry point for Admin
    public: './src/Public/index.js', // Entry point for Public
  },
  output: {
    path: path.resolve(__dirname, 'build'), // Output directory
    filename: '[name].bundle.js',           // Use [name] to create admin.bundle.js and public.bundle.js
  },
  module: {
	rules: [
	  {
		test: /\.(js|jsx)$/, // Update to include .jsx files
		exclude: /node_modules/,
		use: {
		  loader: 'babel-loader',
		},
	  },
	  {
		test: /\.scss$/,
		use: [MiniCssExtractPlugin.loader, 'css-loader', 'sass-loader'],
	  },
	],
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: '[name].bundle.css', // Separate CSS for Admin and Public
    }),
  ],
  resolve: {
	extensions: ['.js', '.jsx'], // Add '.jsx' to automatically resolve JSX files
	fallback: {
	  path: require.resolve('path-browserify'),
	  module: false,
	},
  },
};
