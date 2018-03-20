<?php

use yii\helpers\ArrayHelper;

return ArrayHelper::merge(require __DIR__ . '/common.php', require __DIR__ . '/common_web.php', [
    'language' => 'en-US',
    'id' => 'basic-tests',
    'components' => [
        'request' => [
            'cookieValidationKey' => 'test',
            // but if you absolutely need it set cookie domain to localhost
            /*
            'csrfCookie' => [
                'domain' => 'localhost',
            ],
            */
        ],
    ],
]);
