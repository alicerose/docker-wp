const terserPlugin = require('terser-webpack-plugin');
const webpack = require('webpack');

/**
 * production flag
 * @type {boolean}
 */
const isProduction = process.env.NODE_ENV === 'production';

module.exports = {
  // モードの設定、v4系以降はmodeを指定しないと、webpack実行時に警告が出る
  mode: isProduction ? 'production' : 'development',
  // エントリーポイントの設定
  entry: {
    app: './src/webpack/main.js',
  },
  // 出力の設定
  output: {
    filename: '[name].js',
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        use: [
          {
            loader: 'babel-loader',
            options: {
              presets: [
                [
                  '@babel/preset-env',
                  {
                    useBuiltIns: 'entry',
                    corejs: 3,
                  },
                ],
              ],
              plugins: ['@babel/plugin-proposal-class-properties'],
            },
          },
        ],
      },
    ],
  },
  /**
   * Productionビルド時の最適化
   */
  optimization: {
    minimizer: [
      new terserPlugin({
        cache: false,
        parallel: true,
        sourceMap: false,
        terserOptions: {
          compress: { drop_console: true },
        },
      }),
    ],
  },
  plugins: [
    new webpack.ProvidePlugin({
      /**
       * jqueryをnpmから使用
       */
      $: 'jquery',
      jQuery: 'jquery',
      'window.jQuery': 'jquery',
    }),
  ],
};
