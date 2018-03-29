<?php

namespace app\modules\rbac\models;

use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\base\ModelEvent;
use yii\db\AfterSaveEvent;

abstract class Item extends Model
{
    const EVENT_BEFORE_DELETE = 'beforeDelete';
    const EVENT_AFTER_DELETE = 'afterDelete';
    const EVENT_BEFORE_INSERT = 'beforeInsert';
    const EVENT_AFTER_INSERT = 'afterInsert';
    const EVENT_BEFORE_UPDATE = 'beforeUpdate';
    const EVENT_AFTER_UPDATE = 'afterUpdate';

    public $name;

    public $createdAt;
    public $updatedAt;

    public $isNewRecord = true;

    protected $item;

    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
            'updatedAt' => Yii::t('app', 'Updated At'),
            'createdAt' => Yii::t('app', 'Created At'),
        ];
    }

    public function beforeSave($insert)
    {
        $event = new ModelEvent();
        $this->trigger($insert ? self::EVENT_BEFORE_INSERT : self::EVENT_BEFORE_UPDATE, $event);

        return $event->isValid;
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->trigger($insert ? self::EVENT_AFTER_INSERT : self::EVENT_AFTER_UPDATE, new AfterSaveEvent([
            'changedAttributes' => $changedAttributes,
        ]));
    }

    /**
     * Delete Item
     * @return  boolean
     * @throws Exception When call delete() function in new record
     */
    public function delete()
    {
        if ($this->isNewRecord) {
            throw new Exception('Call delete() function in new record');
        }

        $this->beforeDelete();

        $authManager = Yii::$app->authManager;

        $ret = $authManager->remove($this->item);

        $this->afterDelete();

        return $ret;
    }

    public function beforeDelete()
    {
        $event = new ModelEvent();
        $this->trigger(self::EVENT_BEFORE_DELETE, $event);

        return $event->isValid;
    }

    public function afterDelete()
    {
        $this->trigger(self::EVENT_AFTER_DELETE);
    }
}
