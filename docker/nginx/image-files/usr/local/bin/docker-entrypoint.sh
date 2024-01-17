#!/bin/sh
export DOLLAR='$'

# Fail on any error
set -o errexit

#envsubst < /etc/nginx/conf.d/socket.src > /etc/nginx/conf.d/socket.conf;
#
#rm /etc/nginx/conf.d/socket.src

# Execute CMD
exec "$@"
