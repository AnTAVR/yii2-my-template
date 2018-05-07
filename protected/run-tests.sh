#!/bin/bash

#./yii serve -t '@webroot' &
#PHP_PID=${!}

#./yii-test migrate --interactive=0
#./yii-test migrate --migrationPath=@yii/rbac/migrations --interactive=0
./vendor/bin/codecept build
#cd ..
#./protected/vendor/bin/codecept run -c ./protected --coverage-html
./vendor/bin/codecept run --coverage-html -vv

#kill ${PHP_PID}
