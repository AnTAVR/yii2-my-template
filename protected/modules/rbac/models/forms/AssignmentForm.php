<?php

namespace app\modules\rbac\models\forms;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class AssignmentForm extends Model
{
    public $userId;
    public $roles = [];
    public $permissions = [];

    /**
     *
     * @param integer $userId The id of user use for assign
     * @param array $config
     */
    public function __construct($userId, $config = [])
    {
        parent::__construct($config);

        $this->userId = $userId;
    }

    public function init()
    {
        parent::init();

        $this->roles = ArrayHelper::getColumn($this->Roles(), 'name');
        $this->permissions = ArrayHelper::getColumn($this->Permissions(), 'name');
    }

    public function Roles()
    {
        $authManager = Yii::$app->authManager;
        $items = $authManager->getRolesByUser($this->userId);
        return $items;
    }

    public function Permissions()
    {
        $authManager = Yii::$app->authManager;
        $items = $authManager->getPermissionsByUser($this->userId);
        return $items;
    }

    public function rules()
    {
        return [
            ['roles', 'default'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'roles' => Yii::t('app', 'Roles'),
        ];
    }

    /**
     * Save assignment data
     * @return boolean whether assignment save success
     * @throws \Exception
     */
    public function save()
    {
        $authManager = Yii::$app->authManager;
        $authManager->revokeAll(intval($this->userId));
        if ($this->roles) {
            foreach ($this->roles as $itemName) {
                $authManager->assign($authManager->getRole($itemName), $this->userId);
            }
        }
        if ($this->permissions) {
            foreach ($this->permissions as $itemName) {
                $authManager->assign($authManager->getPermission($itemName), $this->userId);
            }
        }
        return true;
    }
}
