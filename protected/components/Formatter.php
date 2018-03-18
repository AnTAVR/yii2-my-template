<?php

namespace app\components;

use yii\helpers\ArrayHelper;
use yii\i18n\Formatter as OldFormatter;

class Formatter extends OldFormatter
{
    public function behaviors()
    {
        $behaviors = [

        ];
        return ArrayHelper::merge(parent::behaviors(), $behaviors);
    }
}