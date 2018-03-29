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

    const TYPE = null;

    public $name;

    public $createdAt;
    public $updatedAt;

    public $isNewRecord = true;

    protected $item;

    /**
     * Find model by id
     * @param string $name
     * @return null|static
     */
    static public function find($name)
    {
        $authManager = Yii::$app->authManager;

        if (static::TYPE === yii\rbac\Item::TYPE_PERMISSION) {
            $item = $authManager->getPermission($name);
        } elseif (static::TYPE === yii\rbac\Item::TYPE_ROLE) {
            $item = $authManager->getRole($name);
        } else {
            $item = $authManager->getRule($name);
        }

        return $item ? new static($item) : null;
    }

    /**
     * @return null|array
     */
    static public function findAll()
    {
        $authManager = Yii::$app->authManager;

        if (static::TYPE === yii\rbac\Item::TYPE_PERMISSION) {
            $items = $authManager->getPermissions();
        } elseif (static::TYPE === yii\rbac\Item::TYPE_ROLE) {
            $items = $authManager->getRoles();
        } else {
            $items = $authManager->getRules();
        }
        $items = array_map(function ($item) {
            return new static($item);
        }, $items);
        return $items;
    }

    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
            'updatedAt' => Yii::t('app', 'Updated At'),
            'createdAt' => Yii::t('app', 'Created At'),
        ];
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

    public function uniqueValidator()
    {
        $authManager = Yii::$app->authManager;

        if (static::TYPE === yii\rbac\Item::TYPE_ROLE) {
            $item = $authManager->getRole($this->name);
        } elseif (static::TYPE === yii\rbac\Item::TYPE_PERMISSION) {
            $item = $authManager->getPermission($this->name);
        } else {
            $item = $authManager->getRule($this->name);
        }

        if (!$item) {
            $this->addError('name', Yii::t('yii', '{attribute} "{value}" has already been taken.', [
                'attribute' => $this->getAttributeLabel('name'),
                'value' => $this->name,
            ]));
        }
    }

    /**
     * Save item
     * @param bool $runValidation
     * @param null|array $attributeNames
     * @return boolean
     * @throws \Exception
     */
    public function save(/** @noinspection PhpUnusedParameterInspection */
        $runValidation = true, $attributeNames = null)
    {
        if ($runValidation && !$this->validate()) {
            return false;
        }

        $this->beforeSave(false);

        $authManager = Yii::$app->authManager;

        $item = $this->newItem();

        // save
        if ($this->isNewRecord) {
            if (!$authManager->add($item)) {
                return false;
            }
        } else {
            if (!$authManager->update($this->item->name, $item)) {
                return false;
            }
        }

        $this->item = $item;

        $this->createdAt = $item->createdAt;
        $this->updatedAt = $item->updatedAt;

        $this->isNewRecord = false;

        $this->afterSave(false, $this->attributes);

        return true;
    }

    public function beforeSave($insert)
    {
        $event = new ModelEvent();
        $this->trigger($insert ? self::EVENT_BEFORE_INSERT : self::EVENT_BEFORE_UPDATE, $event);

        return $event->isValid;
    }

    /**
     * @return \yii\rbac\Role|\yii\rbac\Permission|\yii\rbac\Rule
     */
    abstract protected function newItem();

    public function afterSave($insert, $changedAttributes)
    {
        $this->trigger($insert ? self::EVENT_AFTER_INSERT : self::EVENT_AFTER_UPDATE, new AfterSaveEvent([
            'changedAttributes' => $changedAttributes,
        ]));
    }
}
