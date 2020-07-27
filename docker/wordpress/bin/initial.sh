#!/usr/bin/env bash

wp plugin install wp-multibyte-patch --activate --allow-root --path=`/var/www/html`
wp theme activate my-theme --allow-root --path=`/var/www/html`

exit 0