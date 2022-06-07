#!/usr/bin/env bash

echo "Check WordPress install"

# === check if installed ===
if ! wp core is-installed; then

  echo "Running initial setup."

  # === initialize config ===
  wp config create \
    --path=${WP_PATH} \
    --dbname=${WP_DB_NAME} \
    --dbuser=${WP_DB_USER} \
    --dbpass=${WP_DB_PASS} \
    --dbhost=${WP_DB_HOST} \
    --dbprefix=${WP_DB_PREF} \
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
