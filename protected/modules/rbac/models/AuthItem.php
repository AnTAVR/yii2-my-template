<?php

namespace app\modules\rbac\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\rbac\Permission;
use yii\rbac\Role;

abstract class AuthItem extends Item
{
    public $description;
    public $ruleName;
    public $data;

    /**
     * @param Role|Permission $item
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

    public function rules()
    {
        return [
            ['name', 'trim'],
            ['name', 'required'],
            ['name', 'string',
                'max' => 64],
            ['name', 'uniqueValidator',
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

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'description' => Yii::t('app', 'Description'),
            'ruleName' => Yii::t('app', 'Rule Name'),
            'data' => Yii::t('app', 'Data'),
            'permissions' => Yii::t('app', 'Permissions'),
        ]);
    }

    protected function newItem()
    {
        $authManager = Yii::$app->authManager;

        if (static::TYPE == \yii\rbac\Item::TYPE_ROLE) {
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

        return $item;
    }

    /**
     * Search auth item
     * @param array $params
     * @return ActiveDataProvider|yii\data\ArrayDataProvider
     */
    public function search($params)
    {
        $authManager = Yii::$app->authManager;
        if (static::TYPE == \yii\rbac\Item::TYPE_ROLE) {
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
