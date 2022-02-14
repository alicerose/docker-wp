/* eslint @typescript-eslint/no-var-requires : 0 */
const path = require('path');
const configs = require('./project.config');
const webpack = require('webpack');
const TerserPlugin = require('terser-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CopyPlugin = require('copy-webpack-plugin');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const Dotenv = require('dotenv-webpack');

const environment = process.env.NODE_ENV || 'local';
const isProduction = process.env.NODE_ENV === 'production';
console.log('Build Environment :', environment);

/**
 * 画像処理の設定準備
 * @param config
 * @return {{type: (string)}}
 */
const prepareImageLoader = (config) => {
  const loader = {
    type     : config.bundleImages ? 'asset' : 'asset/resource',
    generator: {
      filename: config.assetName,
    },
  };
  if (config.bundleImages) {
    loader.parser = {
      dataUrlCondition: {
        maxSize: config.bundleSizeLimit,
      },
    };
  }

  return loader;
};
const imageLoaderBehavior = prepareImageLoader(configs.images);

const app = {
  entry: {
    app  : `./${configs.directories.src}/ts/index.ts`,
    admin: `./${configs.directories.src}/ts/admin.ts`,
  },

  target: ['web', 'es5'],

  module: {
    rules: [
      // ts
      {
        test: /\.ts$/,
        use : 'ts-loader',
      },

      // images
      {
        test: /\.(jpe?g|png|gif|svg|webp)$/,
        ...imageLoaderBehavior,
      },

      // scss
      {
        test: /\.scss/,
        use : [
          // 'style-loader',
          MiniCssExtractPlugin.loader,
          {
            loader : 'css-loader',
            options: {
              url          : true,
              sourceMap    : !isProduction,
              importLoaders: 2,
            },
          },
          {
            loader : 'postcss-loader',
            options: {
              postcssOptions: {
                ...configs.scss.plugins,
              },
            },
          },
          {
            loader : 'sass-loader',
            options: {
              sourceMap: !isProduction,
            },
          },
        ],
      },
    ],
  },

  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'src'),
    },
    extensions: ['.ts', '.js'],
    modules   : ['node_modules'],
  },

  output: {
    filename: 'assets/js/[name].bundle.js',
    path    : path.join(__dirname, configs.directories.dist),
    clean   : true,
  },

  devServer: {
    devMiddleware: {
      writeToDisk: true, // バンドルされたファイルを出力する（実際に書き出す）
    },
  },

  plugins: [
    new Dotenv({
      path    : path.resolve(__dirname, `.env.${environment}`),
      safe    : false,
      defaults: false,
      expand  : true,
    }),
    new MiniCssExtractPlugin({
      // 抽出する CSS のファイル名
      filename: 'assets/css/[name].css',
    }),
    new webpack.ProvidePlugin({
      '$'            : 'jquery',
      'jQuery'       : 'jquery',
      'window.jQuery': 'jquery',
    }),
    new BrowserSyncPlugin({
      proxy    : configs.server.proxy,
      files    : [configs.directories.src + '/scss/**/*.scss', configs.directories.src + '/ts/**/*.ts', configs.directories.src + '/templates/**/*.php' ],
      injectCss: true,
    }, { reload: false, }),
  ],

  optimization: {
    usedExports: true,
    minimizer  : [
      new TerserPlugin({
        parallel     : true,
        terserOptions: {
          compress: { drop_console: isProduction },
        },
      }),
    ],
    splitChunks: {
      cacheGroups: {
        vendor: {
          // node_modules配下はvendorとしてbundle
          test   : /node_modules/,
          name   : 'vendor',
          chunks : 'initial',
          enforce: true,
        },
      },
    },
  },
};

module.exports = (env, argv) => {
  app.mode = argv.mode ?? 'development';
  if (argv.mode !== 'production' && !isProduction) app.devtool = 'source-map';

  const patterns = [
    {
      from: 'src/templates',
      to  : path.join(__dirname, configs.directories.dist),
    },
  ];

  app.plugins.push(new CopyPlugin({ patterns }));

  return app;
};
