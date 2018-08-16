#!/bin/bash -e

printenv >> /etc/environment
./tests/yii schedule/pull
crontab /etc/crontab
cron -f