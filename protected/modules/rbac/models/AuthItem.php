<?php

namespace app\modules\rbac\models;

use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\helpers\Json;
use yii\rbac\Item;

/**
 * @property int $type
 */
abstract class AuthItem extends Model
{
    public $name;
    public $description;
    public $ruleName;
    public $data;
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
        }
        parent::__construct($config);
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
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'string', 'max' => 64],
            ['name', 'unique', 'when' => function () {
                return $this->isNewRecord || ($this->item->name != $this->name);
            }],

            ['ruleName', 'in',
                'range' => array_keys(Yii::$app->authManager->getRules()),
                'message' => Yii::t('app', 'Rule not exists')],
            ['ruleName', 'default'],

            ['description', 'default'],
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

//    /**
//     * Find auth item
//     * @param type $name
//     * @return AuthItem
//     */
//    public abstract static function find($name);

    /**
     * Save item
     * @return boolean
     * @throws \Exception
     * @throws Exception
     */
    public function save()
    {

        if (!$this->validate()) {
            return false;
        }

        //$this->beforeSave();
        $authManager = Yii::$app->authManager;

        // Create new item    
        if ($this->getType() == Item::TYPE_ROLE) {
            $item = $authManager->createRole($this->name);
        } else {
            $item = $authManager->createPermission($this->name);
        }

        // Set item data
        $item->description = $this->description;
        $item->ruleName = $this->ruleName;
        $item->data = $this->data === null || $this->data === '' ? null : Json::decode($this->data);

        // save
        if ($this->item == null && !$authManager->add($item)) {
            return false;
        } else if ($this->item !== null && !$authManager->update($this->item->name, $item)) {
            return false;
        }

        $isNewRecord = $this->item == null ? true : false;
        $this->isNewRecord = !$isNewRecord;
        $this->item = $item;
        //$this->afterSave($isNewRecord,$this->attributes);


        if ($this->getType() == Item::TYPE_ROLE) {
            $role = $authManager->getRole($this->item->name);
            if (!$isNewRecord) {
                $authManager->removeChildren($role);
            }
            if ($this->permissions != null && is_array($this->permissions)) {
                foreach ($this->permissions as $permissionName) {
                    $permission = $authManager->getPermission($permissionName);
                    $authManager->addChild($role, $permission);
                }
            }
        }


        return true;
    }

    /**
     * Get the type of item
     * @return integer
     */
    protected abstract function getType();

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


        $authManager = Yii::$app->authManager;

        // Create new item
        if ($this->getType() == Item::TYPE_ROLE) {
            $item = $authManager->getRole($this->name);
        } else {
            $item = $authManager->getPermission($this->name);
        }

        return $authManager->remove($item);
    }
}
