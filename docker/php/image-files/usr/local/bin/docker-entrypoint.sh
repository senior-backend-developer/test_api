#!/bin/sh

# This script is run within the php containers on start

# Fail on any error
set -o errexit

# Set permissions based on ENV variable (debian only)
if [ -x "usermod" ] ; then
    usermod -u ${PHP_USER_ID} www-data
fi

#chown -R www-data:www-data ./web/storage
chown -R www-data:www-data ./runtime
chown -R www-data:www-data ./assets

export CURRENT_BRANCH=$(git symbolic-ref --short HEAD)

#for f in $(find ./config/local/_docker -regex '.*\.php'); do envsubst < $f > "./config/local/$(basename $f)"; done
for f in $(find ./config/local/_docker -regex '.*\.php'); do envsubst < $f > "./config/local/$(basename $f)"; done

composer.phar install

php yii migrate --interactive=0
php yii cache/flush-all

#service cron start
#
#php yii crontab/list | crontab -

#rm -rf ./web/frontapidoc
#apidoc -i ./modules/api/ -o ./web/frontapidoc

#php yii message/extract config/sections/messages.php
#php yii geo/load

# Execute CMD
exec "$@"
