#!/bin/sh

composer install --prefer-dist --no-interaction \
&& tests/docker/wait-for-it.sh $POSTGRES_HOST:$POSTGRES_PORT -t 180 \
&& exec "$@"
