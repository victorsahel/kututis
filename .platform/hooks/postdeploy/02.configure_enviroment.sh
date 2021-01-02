#!/bin/bash
if [ ! -f /var/app/current/.env ]; then
    cp /var/app/current/.env.example /var/app/current/.env
fi
OUTPUT="$(egrep "^APP_KEY=(.+)$" /var/app/current/.env)"
if [ -z "$OUTPUT" ]; then
    php /var/app/current/artisan key:generate
fi
