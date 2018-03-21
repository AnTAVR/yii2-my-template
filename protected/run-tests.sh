#!/bin/bash

#./yii serve -t '@webroot' &
#PHP_PID=${!}

#./tests/bin/yii migrate --interactive=0
#./vendor/bin/codecept -vvv build
cd ..
./protected/vendor/bin/codecept run -c ./protected

#kill ${PHP_PID}
