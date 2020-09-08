#!/usr/bin/env bash

set -ex;

curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar

chmod +x wp-cli.phar
mv wp-cli.phar /usr/local/bin/wp

wp core download --locale=ja --path=${WORDPRESS_DIR} --allow-root

wp core config \
  --dbname=${WORDPRESS_DB_NAME} --dbuser=${WORDPRESS_DB_USER} --dbpass=${WORDPRESS_DB_PASSWORD} --dbhost=${WORDPRESS_DB_HOST} --dbprefix=wordpress_ \
  --path=${WORDPRESS_DIR} --allow-root

wp core install --url=http://localhost:8080/ --title=テスト --admin_user=admin --admin_password=password --admin_email=test@example.com \
  --path=${WORDPRESS_DIR} --allow-root

wp plugin install \
    classic-editor advanced-custom-fields wp-multibyte-patch application-passwords acf-to-rest-api wp-add-mime-types  \
    --activate --path=${WORDPRESS_DIR} --allow-root

wp plugin uninstall \
    hello \
    --path=${WORDPRESS_DIR} --allow-root

wp theme activate my-theme --path=${WORDPRESS_DIR} --allow-root

wp theme delete \
    twentyseventeen twentynineteen twentytwenty \
    --path=${WORDPRESS_DIR} --allow-root
