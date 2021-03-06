#!/usr/bin/env bash

set -e
# set -x

sh runCodeSniffer.sh

php vendor/bin/phpunit -c test/phpunit.xml

php ./phpstan.phar analyze -c ./phpstan.neon -l 7 src

php ./psalm.phar

#php vendor/bin/infection --configuration=infection.json.dist --log-verbosity=all --only-covered --min-covered-msi=90

#infection_exit_code=$?

#set -e

#if [ "$infection_exit_code" -ne "0" ]; then echo "Infection failed"; cat infection-log.txt;  exit "$infection_exit_code"; fi

echo "Tests completed without problem"

# rerun unit tests to get the stats again, to save scrolling...
php vendor/bin/phpunit -c test/phpunit.xml
