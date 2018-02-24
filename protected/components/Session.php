<?php

namespace app\components;

use Yii;
use yii\helpers\FileHelper;
use yii\web\Session as oldSession;

class Session extends oldSession
{
    public function setSavePath($value)
    {
        $path = Yii::getAlias($value);

        $dirMode = 0775;
        if (!is_dir($path)) {
            FileHelper::createDirectory($path, $dirMode, true);
        }

        parent::setSavePath($value);
    }
}
