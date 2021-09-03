#!/usr/bin/env bash

<< COMMENTOUT

・WPのURLをドキュメントルートにする

COMMENTOUT

set -e;

# リビジョン番号
FILEPATH=${0##*/}
REVISION=${FILEPATH%.*}
MIGRATION_DIR=/var/www/bin/migrations
# envファイルがあれば読み込み
if [ -e ../.env ]; then
  . ../.env
fi

LOG_DIR=${MIGRATION_DIR}/log

if [ -e ${LOG_DIR}/${REVISION}.txt ]; then
  echo "[MIGRATION] ${REVISION}: Already executed."
else
  echo "[MIGRATION] ${REVISION}: Begin."

  # -------------------- 処理開始 --------------------

  # サイトURLの更新
  wp option update home 'http://localhost:8888' --path=${WP_PATH} --allow-root
  wp option update siteurl ${WP_URL} --path=${WP_PATH} --allow-root

  # index.phpを置換して移動
  sed -e "s/'\/wp-blog-header.php'/'\/app\/wp-blog-header.php'/g" ${WP_PATH}/index.php > /var/www/html/index.php

  # htaccessの移動
  cp ${WP_PATH}/.htaccess /var/www/html/.htaccess


  # -------------------- 処理終了 --------------------

  mv ${LOG_DIR}/${REVISION}.temp.txt ${LOG_DIR}/${REVISION}.txt
  echo "[MIGRATION] ${REVISION}: Done."
fi

exit 0;
