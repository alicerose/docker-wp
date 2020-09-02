import { dest, watch, src, task, series } from 'gulp';
import del from 'del';
import browser from 'browser-sync';
import gulpIf from 'gulp-if';
import sass from 'gulp-sass';
import sourcemaps from 'gulp-sourcemaps';
import postcss from 'gulp-postcss';
import autoprefixer from 'autoprefixer';
import flexBugFixes from 'postcss-flexbugs-fixes';
import webpack from 'webpack';
import webpackStream from 'webpack-stream';
import webpackConfig from './webpack.config';

/**
 * productionビルド
 * @type {boolean}
 */
const isProduction = process.env.NODE_ENV === 'production';

/**
 * ディレクトリ
 * @type {{src: string, dist: string}}
 */
const dir = {
  src: 'src',
  dist: 'my-theme',
  assets: '/assets',
};

/**
 * 設定項目
 * @type {{server: {proxy: string}, scss: {plugins: [*, *], style: {prod: {outputStyle: string}, dev: {outputStyle: string}}}}}
 */
const config = {
  server: {
    proxy: 'localhost:8080',
  },
  scss: {
    style: {
      dev: { outputStyle: 'expanded' },
      prod: { outputStyle: 'compressed' },
    },
    plugins: [autoprefixer({ grid: true }), flexBugFixes()],
  },
};

/**
 * 開発サーバ
 */
task('server', () => {
  browser.init(config.server);
});

/**
 * 開発サーバのリロード
 */
task('reload', done => {
  browser.reload();
  done();
});

/**
 * SCSSコンパイル
 */
task('scss', () => {
  return src(dir.src + '/scss/**/*.scss')
    .pipe(sourcemaps.init())
    .pipe(sass(isProduction ? config.scss.style.prod : config.scss.style.dev))
    .pipe(postcss(config.scss.plugins))
    .pipe(gulpIf(!isProduction, sourcemaps.write()))
    .pipe(dest(dir.dist + dir.assets + '/css/'))
    .pipe(browser.stream());
});

/**
 * WebpackでJSのコンパイル
 */
task('js', () => {
  return webpackStream(webpackConfig, webpack)
    .pipe(dest(dir.dist + dir.assets + '/js/'))
    .pipe(browser.stream());
});

/**
 * ファイル更新監視
 */
task('watch', done => {
  watch(dir.src + '/scss/**/*.scss', task('scss'));
  watch(dir.src + '/webpack/**/*.js', task('js'));
  watch(dir.dist + '/**/*.php', task('reload'));
  done();
});

/**
 * ビルドしたアセットディレクトリの削除
 */
task('clean', () => {
  return del([dir.dist + dir.assets]);
});

/**
 * ビルドタスク
 */
task('build', series('clean', 'scss', 'js'));

/**
 * 標準タスク
 */
task('default', series('build', 'watch', 'server'));
