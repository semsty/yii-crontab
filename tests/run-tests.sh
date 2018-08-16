#!/bin/bash -e

cd `dirname $0`/../

docker-compose pull
docker-compose build
docker-compose run php72 "./tests/yii migrate --interactive=0 && vendor/bin/phpunit --verbose"
docker-compose down -v
