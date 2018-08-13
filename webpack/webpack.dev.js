'use strict'

const webpack         = require('webpack')
const merge           = require('webpack-merge')
const StyleLintPlugin = require('stylelint-webpack-plugin')
const DashboardPlugin = require('webpack-dashboard/plugin')

module.exports = merge.smart(require('./webpack.common'), {
  optimization: {
    splitChunks: {
      chunks: 'all'
    }
  },

  module: {
    rules: [
      {
        enforce: 'pre',
        test: /\.js$/,
        exclude: /node_modules/,
        use: [
          {
            loader: 'eslint-loader'
          }
        ]
      }
    ]
  },

  plugins: [
    new StyleLintPlugin(),
    new DashboardPlugin({
      minified: false,
      gzip: false
    }),
    new webpack.HotModuleReplacementPlugin()
  ],

  devServer: {
    historyApiFallback: true,
    noInfo: true,
    overlay: {
      warnings: true,
      errors: true
    },
    host: '0.0.0.0',
    port: 8000,
    disableHostCheck: true,
    open: true,
    contentBase: './dist',
    headers: {
      'Access-Control-Allow-Origin': '*'
    },
    stats: {
      colors: true
    }
  },

  devtool: 'inline-source-map',

})
