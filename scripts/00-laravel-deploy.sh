#!/usr/bin/env bash
#
# /*
#  * © ${YEAR} Demilade Oyewusi
#  * Licensed under the MIT License.
#  * See the LICENSE file for details.
#  */
#

echo "Running composer"
composer global require hirak/prestissimo
composer install --no-dev --working-dir=/var/www/html

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate:fresh --seed
