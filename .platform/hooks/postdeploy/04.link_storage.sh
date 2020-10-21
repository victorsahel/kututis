#!/bin/bash
if [ ! -L /var/app/current/public/storage ]; then
  php /var/app/current/artisan storage:link
fi
