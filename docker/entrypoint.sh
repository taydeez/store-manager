#
# /*
#  * © ${YEAR} Demilade Oyewusi
#  * Licensed under the MIT License.
#  * See the LICENSE file for details.
#  */
#

[supervisord]
nodaemon=true

[program:php-fpm]
command=/bin/sh -c " php-fpm"
priority=10
autostart=true
autorestart=true

[program:nginx]
command=nginx -g "daemon off;"
priority=20
autostart=true
autorestart=true
