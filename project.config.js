// eslint-disable-next-line @typescript-eslint/no-var-requires
const flexBugFixes = require('postcss-flexbugs-fixes');

module.exports = {
  directories: {
    src : 'src',
    dist: 'dist',
  },
  scss: {
    plugins: [['autoprefixer', { grid: true }],flexBugFixes()],
  },
  images: {
    // 画像をバンドルするか否か
    bundleImages: false,

    // 一定サイズ以下のファイルはバンドルする場合
    bundleSizeLimit: 3 * 1024,

    // 特定の階層に書き出す場合
    assetName: './assets/images/[name].[contenthash][ext]',
  },
  server: {
    proxy: 'http://localhost:8888/',
    open : 'external'
  }
};
