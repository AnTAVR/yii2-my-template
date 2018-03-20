<?php

use yii\helpers\ArrayHelper;

return ArrayHelper::merge(require __DIR__ . '/common.php', require __DIR__ . '/common_web.php', [
    'id' => 'basic',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'jXBjnr3BwJb-0lXBx8fZfYKKGdqkXb-X',
        ],
    ],
]);
