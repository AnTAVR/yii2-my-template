#!/bin/bash
cd ..

php -S localhost:8080 &
PHP_PID=${!}

cd protected

#./tests/bin/yii migrate
#./vendor/bin/codecept -vvv build
./vendor/bin/codecept -vvv run

kill ${PHP_PID}
