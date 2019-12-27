# Wordpress用docker

## 必要なもの

* `Docker`
    * インストールが完了しており、`docker version`でバージョン情報が取得出来る状態にあること 

## 初期設定

* 当リポジトリの内容をcloneまたはダウンロードし、任意のディレクトリに展開
* `cd {{ 作業ディレクトリ }}`
* `docker-compose up -d`
* 初回起動時は`www`、`.data`ディレクトリが作成される
    * `www`がいわゆる`htdocs`になる
    * 起動完了するまでは少し時間がかかるのでアクセス時にエラーが出る場合は少し待ってみること
* `localhost:8000`にアクセスし、WPの初期設定が済めば完了

## 内容

|Service|Host|備考|
|:---|:---|:---|
|Apache|`http://localhost:8000`|初回起動時にWordpressを自動インストールする|
|PHPMyAdmin|`http://localhost:8081/`|`root`でログイン状態|
|MailHog|`http://localhost:8025/`|ローカルメールサーバ|
|MariaDB|`localhost:3306`|PHPMyAdmin以外で叩く場合は`127.0.0.1:3306`|