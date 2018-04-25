#!/bin/bash

cd /usr/src/b2ei-energy-monitor/
git pull
php artisan migrate
chmod 777 -R /usr/src/b2ei-energy-monitor/storage/
rm -rf /usr/src/b2ei-energy-monitor/.require-update



