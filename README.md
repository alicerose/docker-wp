# Wordpressテンプレート

## 概要

* WordPress開発用Docker
* TypeScript, Scss ready
* Webpack駆動、HMRは一旦諦めた

## Docker構成

|ホスト|コンテナ| 詳細・備考                                                              |
|:---|:---|:-------------------------------------------------------------------|
|http://localhost:8080|Apache| PHP 8.1                                                            |
|http://localhost:3306|MariaDB| Volume化                                                            |
|http://localhost:8081|PhpMyAdmin||
|http://localhost:8025|MailHog| WordPressから配信されたメールをインターセプトする<br>永続化されていないのでコンテナを落とすと受信済みデータは消去される |

## ディレクトリ構成

## htaccess

## Webpack関連

* 基本的には[静的ページ構築用Webpackテンプレート](https://github.com/alicerose/webpack-starter) と同じ
* `WordPressInfoClass` というテンプレート識別用ユーティリティが追加されています
  * 大まかなWordPress標準のテンプレート種別は判定出来るはず
  * 使い方は`ts/index.ts`を見てください

## リリースノート

https://github.com/alicerose/docker-wp/releases
