<?php

namespace app\modules\rbac\models\searches;

use app\modules\rbac\models\AuthItem;
use Yii;
use yii\data\ArrayDataProvider;
use yii\rbac\Item;

abstract class AuthItemSearch extends AuthItem
{
//    public static function find(/** @noinspection PhpUnusedParameterInspection */
//        $name)
//    {
//        throw new Exception('Not support find() method in this object');
//    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'safe'],
        ];
    }

    /**
     * Search auth item
     * @param array $params
     * @return \yii\data\ActiveDataProvider|\yii\data\ArrayDataProvider
     */
    public function search($params)
    {
        $authManager = Yii::$app->authManager;
        if ($this->getType() == Item::TYPE_ROLE) {
            $items = $authManager->getRoles();
        } else {
            $items = $authManager->getPermissions();
        }

        if ($this->load($params) && $this->validate() && (trim($this->name) !== '' || trim($this->description) !== '')) {
            $search = strtolower(trim($this->name));
            $desc = strtolower(trim($this->description));
            $items = array_filter($items, function ($item) use ($search, $desc) {
                return (empty($search) || strpos(strtolower($item->name), $search) !== false) && (empty($desc) || strpos(strtolower($item->description), $desc) !== false);
            });
        }
        return new ArrayDataProvider([
            'allModels' => $items,
        ]);
    }

}
