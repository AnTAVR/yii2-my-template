#!/bin/bash

./yii serve -t '@webroot' &
PHP_PID=${!}

#./tests/bin/yii migrate
#./vendor/bin/codecept -vvv build
./vendor/bin/codecept -vvv run

kill ${PHP_PID}
