const webpack               = require('webpack')
const path                  = require('path')
const MiniCssExtractPlugin  = require('mini-css-extract-plugin')
const CleanWebpackPlugin    = require('clean-webpack-plugin')

module.exports = {
  entry: [
    './src/scripts/main.js',
    './src/styles/main.scss'
  ],
  output: {
    path: path.resolve(__dirname, '../dist'),
    publicPath: '/dist/',
    filename: 'scripts/[name].js'
  },

  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: [
          {
            loader: 'babel-loader'
          }
        ]
      },
      {
        test: /\.scss$/,
        use: [
          {
            loader: MiniCssExtractPlugin.loader,
          },
          {
            loader: 'css-loader',
            options: {
              importLoaders: 1
            }
          },
          {
            loader: 'postcss-loader'
          },
          {
            loader: 'sass-loader'
          }
        ]
      },
      {
        test: /\.(png|jpg|gif|svg|woff|woff2|eot|ttf)(\?v=[0-9]\.[0-9]\.[0-9])?$/,
        use: [
          {
            loader: 'url-loader',
            options: {
              // Inline files smaller than 10 kB (10240 bytes)
              limit: 10 * 1024
            }
          }
        ]
      },
      {
        test: /\.svg(\?v=[0-9]\.[0-9]\.[0-9])?$/,
        use: [
          {
            loader: 'svg-url-loader',
            options: {
              // Inline files smaller than 10 kB (10240 bytes)
              limit: 10 * 1024,
              // Remove the quotes from the url
              // (they’re unnecessary in most cases)
              noquotes: true,
              iesafe: true
            }
          }
        ]
      },
      {
        test: /\.md/,
        use: [
          {
            loader: 'raw-loader'
          }
        ]
      },
    ]
  },

  plugins: [
    new CleanWebpackPlugin(['dist']),
    new webpack.ProvidePlugin({
      $: 'jquery',
      jQuery: 'jquery'
    }),
    new MiniCssExtractPlugin({
      // Options similar to the same options in webpackOptions.output
      // both options are optional
      filename: "styles/[name].css",
      chunkFilename: "[id].css"
    }),
  ],
}
