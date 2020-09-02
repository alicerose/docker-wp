#!/usr/bin/env bash

set -ex;
WPINSTALLDIR=/var/www/html

curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar

chmod +x wp-cli.phar
mv wp-cli.phar /usr/local/bin/wp

wp plugin install \
    classic-editor advanced-custom-fields wp-multibyte-patch application-passwords acf-to-rest-api wp-add-mime-types  \
    --activate --path=${WPINSTALLDIR} --allow-root

wp theme activate my-theme --path=${WPINSTALLDIR} --allow-root