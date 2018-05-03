#!/bin/bash

#./yii serve -t '@webroot' &
#PHP_PID=${!}

#./yii-test migrate --interactive=0
#./yii-test migrate --migrationPath=@yii/rbac/migrations --interactive=0
./vendor/bin/codecept -vvv build
cd ..
./protected/vendor/bin/codecept run -c ./protected

#kill ${PHP_PID}
