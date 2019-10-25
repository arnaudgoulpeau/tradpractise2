#bin/bash

if [ ! -d "/srv/app/vendor" ]; then
    composer install
fi

#php bin/console assets:install web

/srv/wait-for-mariadb.sh

# set database and fixtures

php bin/console doctrine:database:drop --no-interaction --force
php bin/console doctrine:database:create --no-interaction

mysql --host=mariadb -u"$MYSQL_USER" -p"$MYSQL_PASSWORD" musicpractise < /srv/app/var/dumps/datadump.sql


php bin/console doctrine:schema:update --force --no-interaction

# start server
php bin/console server:run 0.0.0.0:8000

