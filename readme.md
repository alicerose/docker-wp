# Wordpress用docker

* テーマファイル郡だけgit管理したいDockerを作る

## 必要なもの

* `Docker`
    * https://www.docker.com/
    * `Docker Desktop`を推奨
    * インストールが完了しており、`docker version`でバージョン情報が取得出来る状態にあること 

## 初期設定

* 当リポジトリの内容をcloneまたはダウンロードし、任意のディレクトリに展開
* `cd {{ 作業ディレクトリ }}`
* `docker-compose up -d`
    * CLI上のdockerで`db`が`done`になっても、初期化が終わるまでは正常に表示されないのでしばらく待つ
    * dbコンテナのログに`[Note] mysqld: ready for connections.` が表示されていれば恐らくOK
* `http://localhost:8080/` にアクセス
    * 初期設定画面が出たらそのまま続行
* 初期設定が済んだらdockerのコンテナ内に入る
    * 以下はDocker for Macのキャプチャ
    * ![figure1](./docker/images/image0.png "")
        * DockerのメニューからDashboardを開く
    * ![figure2](./docker/images/image1.png "")
        * 起動しているDockerから「***_wordpress」とついているコンテナのCLIボタンを押す
    * ![figure3](./docker/images/image2.png "")
        * `sh /var/www/bin/install.sh` を実行
        * シェルは`/bin/install.sh`がコピーされているもの
        * `WP-CLI`のインストール、デフォルトプラグインのインストール・有効化、テーマの有効化が行われる

## install.sh

* WP-CLIをインストールして、初期設定ぽいことをする
* 以下のプラグインをインストールし、有効化する
    * classic-editor
    * advanced-custom-fields
    * wp-multibyte-patch
* このリポジトリで管理するテーマを有効化する

```bash
#!/usr/bin/env bash

set -ex;
WPINSTALLDIR=/var/www/html

curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar

chmod +x wp-cli.phar
mv wp-cli.phar /usr/local/bin/wp

wp plugin install \
    classic-editor advanced-custom-fields wp-multibyte-patch \
    --activate --path=${WPINSTALLDIR} --allow-root

wp theme activate my-theme --path=${WPINSTALLDIR} --allow-root
```

## Docker構造

|ホスト|コンテナ|詳細・備考|
|:---|:---|:---|
|http://localhost:8080|Wordpress||
|http://localhost:3306|MariaDB||
|http://localhost:8081|PhpMyAdmin||
|http://localhost:8025|MailHog|Wordpressから配信されたメールをインターセプトする|

