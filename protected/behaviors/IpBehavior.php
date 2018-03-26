<?php

namespace app\behaviors;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\BaseActiveRecord;

class IpBehavior extends AttributeBehavior
{
    const CONSOLE_IP = '0.0.0.0';

    public $createdAtAttribute = 'created_ip';
    public $updatedAtAttribute = 'updated_ip';
    public $value;

    public function init()
    {
        parent::init();

        if (empty($this->attributes)) {
            $this->attributes = [
                BaseActiveRecord::EVENT_BEFORE_INSERT => [$this->createdAtAttribute, $this->updatedAtAttribute],
                BaseActiveRecord::EVENT_BEFORE_UPDATE => $this->updatedAtAttribute,
            ];
        }
    }

    protected function getValue($event)
    {
        if ($this->value === null) {
            return Yii::$app->request->isConsoleRequest ? static::CONSOLE_IP : Yii::$app->request->userIP;
        }

        return parent::getValue($event);
    }
}