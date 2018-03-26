<?php

namespace app\modules\rbac\models\forms;

use Yii;
use yii\base\Model;

class AssignmentForm extends Model
{

    public $userId;
    public $roles = [];
    public $authManager;

    /**
     *
     * @param integer $userId The id of user use for assign
     * @param array $config
     */
    public function __construct($userId, $config = [])
    {
        parent::__construct($config);
        $this->userId = $userId;
        $this->authManager = Yii::$app->authManager;
        foreach ($this->authManager->getRolesByUser($userId) as $role) {
            $this->roles[] = $role->name;
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['userId', 'required'],
            ['roles', 'default'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'userId' => Yii::t('app', 'User ID'),
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
        $this->authManager->revokeAll(intval($this->userId));
        if ($this->roles != null) {
            foreach ($this->roles as $role) {
                $this->authManager->assign($this->authManager->getRole($role), $this->userId);
            }
        }
        return true;
    }

}
