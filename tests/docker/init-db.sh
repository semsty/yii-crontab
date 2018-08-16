#!/bin/bash

echo "creating user app..."
psql -c "CREATE USER app WITH SUPERUSER PASSWORD 'password';"

echo "creating app_db..."
createdb -U app -T template0 -E UTF-8 -l en_US.UTF-8 -O app app_db
