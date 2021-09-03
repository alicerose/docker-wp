#!/usr/bin/env bash

<< COMMENTOUT

  Migrationっぽいことをするシェルスクリプト

COMMENTOUT

set -e;

sleep 5

echo "[MIGRATION] Start."

#curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
#chmod +x wp-cli.phar
#mv wp-cli.phar /usr/local/bin/wp

MIGRATION_DIR=/var/www/bin/migrations

# envファイルがあれば読み込み
if [ -e .env ]; then
  . .env
fi

echo "Migration Directory: ${MIGRATION_DIR}"
LOG_DIR=${MIGRATION_DIR}/log

if [ -e ${LOG_DIR}/ ]; then
  echo "Log directory found."
else
  mkdir ${LOG_DIR}
  echo "Log directory created."
fi

# -------------------- ここからリビジョンファイル --------------------

# 初期設定
sh ${MIGRATION_DIR}/00000000.sh | tee ${LOG_DIR}/00000000.temp.txt

# WPを子ディレクトリにインストールしてURLはドキュメントルートにする
# 必要なければコメントアウト
sh ${MIGRATION_DIR}/00000001.sh | tee ${LOG_DIR}/00000001.temp.txt

# -------------------- ここまでリビジョンファイル --------------------

rm -v ${LOG_DIR}/*.temp.txt

echo "[MIGRATION] End."
exit 0;
