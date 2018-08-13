'use strict'

const webpack                 = require('webpack')
const merge                   = require('webpack-merge')
const MiniCssExtractPlugin    = require('mini-css-extract-plugin')
const UglifyJsPlugin          = require('uglifyjs-webpack-plugin')
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin')


module.exports = merge.smart(require('./webpack.common'), {
  optimization: {
    nodeEnv: 'production',
    minimize: true,
    concatenateModules: true,
    // runtimeChunk: true,
    splitChunks: {
      chunks: 'all',
      cacheGroups: {
        styles: {
          name: 'styles',
          test: /\.css$/,
          chunks: 'all',
          enforce: true
        }
      }
    }
  },

  module: {
    rules: [
      {
        test: /\.scss$/,
        use: [
          {
            loader: 'css-loader',
            options: {
              minimize: true
            }
          }
        ]
      },
      {
        enforce: 'pre',
        test: /\.(jpe?g|png|gif|svg)(\?v=[0-9]\.[0-9]\.[0-9])?$/,
        use: [
          {
            loader: 'image-webpack-loader',
          }
        ]
      },
    ],
  },

  plugins: [
    new webpack.HashedModuleIdsPlugin(),
    new UglifyJsPlugin({
      cache: true,
      parallel: true,
      sourceMap: true // set to true if you want JS source maps
    }),
    new OptimizeCSSAssetsPlugin({}),
  ],

  devtool: 'source-map',

})
