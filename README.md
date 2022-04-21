# Wordpressテンプレート

## 概要

* WordPress開発用Docker
* TypeScript, Scss ready
* Webpack駆動、HMRは一旦諦めた

## 対象環境

* Docker Desktop
* Node.js `v16.13.0`
* PHP `8.x`
  * 一部名前付き引数で関数を追加しているため

## Docker構成

|ホスト|コンテナ| 詳細・備考                                                            |
|:---|:---|:-----------------------------------------------------------------|
|http://localhost:8080|Apache| PHP 8.1                                                          |
|http://localhost:3306|MariaDB| Volume化                                                          |
|http://localhost:8081|PhpMyAdmin||
|http://localhost:8025|MailHog|WordPressから配信されたメールをインターセプトする<br>永続化されていないのでコンテナを落とすと受信済みデータは消去される|

## ディレクトリ構成

| ディレクトリ    | サブディレクトリ    | 用途            | 備考                                           |
|:----------|:------------|:--------------|:---------------------------------------------|
| `.data`   |             | 永続化用マウントデータ   | `.gitignore`済み<br>自動生成されなくなった                |
| `.docker` |             | Docker用構成ファイル郡|                                              |
| `bin`     |             | シェルスクリプト郡     | 要Envファイル設定                                   |
| `dist`    |             | ビルド済みデータ      | `.gitignore済み`<br>Docker上へはこのディレクトリをマウントしている |
| `src`     | `assets`    | 静的ファイル配置用     |                                              |
| `src`     | `scss`      | スタイルシート郡      | Scss                                         |
| `src`     | `templates` | テンプレートファイル    |                                              |
| `src`     | `ts`        | スクリプトファイル     | TypeScript                                   |

## npmスクリプト

| コマンド               | 用途              | 備考                         |
|:-------------------|:----------------|:---------------------------|
| `dev`              | npm開発環境起動       | localhost:8888をproxy       |
| `build:develop`    | developビルド      ||
| `build:production` | productionビルド   ||
| `docker:build`     | dockerファイルビルド   ||
| `docker:up`        | docker-compose起動 ||
| `docker:down`      | docker-compose停止 ||
| `mutagen:up`       | mutagen-compose起動 | 要mutagenインストール             |
| `mutagen:down`     | mutagen-compose停止 | 要mutagenインストール             |
| `convert-webp`     | webP変換スクリプト実行   | 要cwebpインストール               |
| `deploy:develop`   | develop環境へのデプロイ | 要APP_URL、APP_DEPLOY_TARGET |
| `archiver`         | distのアーカイブ化     | 要ZIP_NAME                  |
| `error_log`        | エラーログをtail      ||

### mutagen

* MacにおいてDockerのボリュームが遅いのを代替する
  * 概ねレスポンスが300%程度早い
* 環境によってはあまり安定しない様子？
* 導入については下記参照
  * `brew install mutagen-io/mutagen/mutagen`
  * https://mutagen.io/documentation/introduction/installation

### Convert WebP

* `src/assets/images`配下の画像をwebpに変換する
  * 当該ディレクトリが存在しない場合は処理中断する
* オリジナルのファイル名.webpと命名したファイルを生成する
* `cwebp`が必要
  * https://developers.google.com/speed/webp

### Deploy

* ビルド後のデータを指定環境に対してrsyncで同期する
* sshが行えない環境に対しては、Archiverでzipファイルを生成したものをアップロード

## WordPress

以下の内容が実装済み

* 空のテーマ
* 頻出カスタマイズ項目の事前設定
  * `src/templates/configs/` 以下のファイルに設定値を変えるだけで反映出来る
  * 大半はtrue/false、一部配列にて記述が必要
* テンプレート実装用の基底クラス郡
  * `src/templates/classes`
  * 投稿データなどの取得（カスタム投稿タイプ、タクソノミーを含む）が出来る
  * カスタムフィールドの取得等があればここからExtendすれば良いという発想
  * デフォルトのWP関数は参照するのに覚えづらかったので簡略化したかった
  * `core`にいるファイル郡はいじらず、編集の際はその上位ディレクトリでextendする想定

## htaccess

* `.htaccess`をプロジェクトルートに作成
* docker-composeファイルのコメントアウトを解除してマウントする
* 同期したファイルに各自追記
  * コンテナ初回起動時はWPインストール時に存在しない可能性があるため、パーマリンク設定の更新後に上記パスを確認

|定義| 用途    | 備考                            |
|:---|:------|:------------------------------|
|`WP_ENV`| 環境名指定 | `local-dev`がテーマファイル開発者用という想定* |

* Dockerデフォルトは`docker`
* 開発、ステージング、本番はそれぞれ`development` `staging` `production`を想定

## Webpack関連

* 基本的には[静的ページ構築用Webpackテンプレート](https://github.com/alicerose/webpack-starter) と同じ
* `WordPressInfoClass` というテンプレート識別用ユーティリティが追加されています
  * 大まかなWordPress標準のテンプレート種別は判定出来るはず
  * 使い方は`ts/index.ts`を見てください

## リリースノート

https://github.com/alicerose/docker-wp/releases

* 4.0はts導入対応のためにwebpack構成を刷新してますが、リリースされてないためリリースノート上はスキップしてます
