<?php

namespace app\modules\rbac\models\forms;

use Yii;
use yii\base\Model;

class AssignmentForm extends Model
{
    public $roles = [];

    /**
     *
     * @param integer $userId The id of user use for assign
     * @param array $config
     */
    public function __construct($userId, $config = [])
    {
        parent::__construct($config);
        foreach (Yii::$app->authManager->getRolesByUser($userId) as $role) {
            $this->roles[] = $role->name;
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['roles', 'default'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'roles' => Yii::t('app', 'Roles'),
        ];
    }

    /**
     * Save assignment data
     * @param integer $userId
     * @return boolean whether assignment save success
     * @throws \Exception
     */
    public function save($userId)
    {
        $authManager = Yii::$app->authManager;
        $authManager->revokeAll(intval($userId));
        if ($this->roles != null) {
            foreach ($this->roles as $role) {
                $authManager->assign($authManager->getRole($role), $userId);
            }
        }
        return true;
    }

}
