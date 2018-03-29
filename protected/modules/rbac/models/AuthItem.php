<?php

namespace app\modules\rbac\models;

use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\base\ModelEvent;
use yii\data\ArrayDataProvider;
use yii\db\AfterSaveEvent;
use yii\helpers\Json;
use yii\rbac\Item;

abstract class AuthItem extends Model
{
    const EVENT_BEFORE_DELETE = 'beforeDelete';
    const EVENT_AFTER_DELETE = 'afterDelete';
    const EVENT_BEFORE_INSERT = 'beforeInsert';
    const EVENT_AFTER_INSERT = 'afterInsert';
    const EVENT_BEFORE_UPDATE = 'beforeUpdate';
    const EVENT_AFTER_UPDATE = 'afterUpdate';

    public $name;
    public $type;
    public $description;
    public $ruleName;
    public $data;
    public $createdAt;
    public $updatedAt;

    public $isNewRecord = true;
    public $permissions;

    protected $item;

    /**
     * @param yii\rbac\Item $item
     * @param array $config name-value pairs that will be used to initialize the object properties
     */
    public function __construct($item, $config = [])
    {
        $this->item = $item;
        if ($item !== null) {
            $this->isNewRecord = false;

            $this->name = $item->name;
            $this->description = $item->description;
            $this->ruleName = $item->ruleName;
            $this->data = $item->data === null ? null : Json::encode($item->data);
            $this->createdAt = $item->createdAt;
            $this->updatedAt = $item->updatedAt;
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'trim'],
            ['name', 'required'],
            ['name', 'string',
                'max' => 64],
            ['name', 'unique',
                'when' => function () {
                    return $this->isNewRecord || ($this->item->name != $this->name);
                }],

            ['ruleName', 'trim'],
            ['ruleName', 'string',
                'max' => 64],
            ['ruleName', 'in',
                'range' => array_keys(Yii::$app->authManager->getRules()),
                'message' => Yii::t('app', 'Rule not exists')],
            ['ruleName', 'default'],

            ['description', 'trim'],
            ['description', 'string', 'max' => 64],
            ['description', 'default'],

            ['data', 'trim'],
            ['data', 'default'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'ruleName' => Yii::t('app', 'Rule Name'),
            'data' => Yii::t('app', 'Data'),
            'permissions' => Yii::t('app', 'Permissions'),
        ];
    }

    public function unique()
    {
        $authManager = Yii::$app->authManager;
        if ($authManager->getRole($this->name) !== null || $authManager->getPermission($this->name) !== null) {
            $this->addError('name', Yii::t('yii', '{attribute} "{value}" has already been taken.', [
                'attribute' => $this->getAttributeLabel('name'),
                'value' => $this->name,
            ]));
        }
    }

    /**
     * Save item
     * @param bool $runValidation
     * @param null $attributeNames
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

        // Create new item    
        if ($this->type == Item::TYPE_ROLE) {
            $item = $authManager->createRole($this->name);
        } else {
            $item = $authManager->createPermission($this->name);
        }

        // Set item data
        $item->description = $this->description;
        $item->ruleName = $this->ruleName;

        if ($this->data) {
            $item->data = Json::decode($this->data);
        }

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

        $this->isNewRecord = false;

        $this->item = $item;

        $this->createdAt = $item->createdAt;
        $this->updatedAt = $item->updatedAt;

        $this->afterSave(false, $this->attributes);

        return true;
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
     * Delete AuthItem
     * @return  boolean whether the role or permission is successfully removed
     * @throws Exception When call delete() function in new record
     */
    public function delete()
    {
        if ($this->isNewRecord) {
            throw new Exception('Call delete() function in new record');
        }

        $this->beforeDelete();

        $authManager = Yii::$app->authManager;

        if ($this->type == Item::TYPE_ROLE) {
            $item = $authManager->getRole($this->name);
        } else {
            $item = $authManager->getPermission($this->name);
        }

        $ret = $authManager->remove($item);

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

    /**
     * Search auth item
     * @param array $params
     * @return \yii\data\ActiveDataProvider|\yii\data\ArrayDataProvider
     */
    public function search($params)
    {
        $authManager = Yii::$app->authManager;
        if ($this->type == Item::TYPE_ROLE) {
            $items = $authManager->getRoles();
        } else {
            $items = $authManager->getPermissions();
        }

        if ($this->load($params) && $this->validate() && ($this->name || $this->description !== '')) {
            $search = strtolower($this->name);
            $desc = strtolower($this->description);
            $items = array_filter($items, function ($item) use ($search, $desc) {
                return (empty($search) || strpos(strtolower($item->name), $search) !== false) && (empty($desc) || strpos(strtolower($item->description), $desc) !== false);
            });
        }
        return new ArrayDataProvider([
            'allModels' => $items,
        ]);
    }
}
