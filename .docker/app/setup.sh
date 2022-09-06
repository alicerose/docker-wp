#!/usr/bin/env bash

echo "Check WordPress install"

# === check if installed ===
if ! wp core is-installed; then

  echo "Running initial setup."

  # === initialize config ===
  wp config create \
    --path=${WP_PATH} \
    --dbname=${WORDPRESS_DB_NAME} \
    --dbuser=${WORDPRESS_DB_USER} \
    --dbpass=${WORDPRESS_DB_PASSWORD} \
    --dbhost=${WORDPRESS_DB_HOST} \
    --dbprefix=${WORDPRESS_TABLE_PREFIX} \
    --locale=ja

  # === install ===
  wp core install \
    --url=${WP_URL} \
    --title=${WP_NAME} \
    --admin_user=${WP_USER} \
    --admin_password=${WP_PASS} \
    --admin_email=${WP_MAIL}

  # === install and set japanese ===

  wp language core install ja
  wp site switch-language ja
  wp language core update

fi