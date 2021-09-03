#!/usr/bin/env bash

<< COMMENTOUT

・初期化

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

  echo "[WP-INSTALL] STEP1: download wordpress"
  wp core download --path=${WP_PATH} --allow-root \
      --locale=ja

  echo "[WP-INSTALL] STEP2: generate wp-config.php"
  wp config create --path=${WP_PATH} --allow-root \
      --dbname=${WP_DB_NAME} \
      --dbuser=${WP_DB_USER} \
      --dbpass=${WP_DB_PASS} \
      --dbhost=${WP_DB_HOST} \
      --dbprefix=${WP_DB_PREF}

  echo "[WP-INSTALL] STEP3: install wordpress"
  wp core install --path=${WP_PATH} --allow-root \
      --url=${WP_URL} \
      --title=${WP_NAME} \
      --admin_user=${WP_USER} \
      --admin_password=${WP_PASS} \
      --admin_email=${WP_MAIL}
  wp language core update --path=${WP_PATH} --allow-root
  wp rewrite structure '/%post_id%/' --path=${WP_PATH} --allow-root

  echo "[WP-INSTALL] STEP4: install plugins"
  wp plugin install --path=${WP_PATH} --allow-root \
      classic-editor advanced-custom-fields wp-multibyte-patch wp-add-mime-types check-email wp-taxonomy-import duplicate-post user-switching \
      --activate
  wp language plugin update --all --path=${WP_PATH} --allow-root

  echo "[WP-INSTALL] STEP5: activate themes"
  wp theme activate ${WP_THEME} --path=${WP_PATH} --allow-root

  # -------------------- 処理終了 --------------------

  mv ${LOG_DIR}/${REVISION}.temp.txt ${LOG_DIR}/${REVISION}.txt
  echo "[MIGRATION] ${REVISION}: Done."
fi

exit 0;
