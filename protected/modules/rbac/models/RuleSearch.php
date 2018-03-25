<?php

namespace app\modules\rbac\models;

use Yii;
use yii\data\ArrayDataProvider;

class RuleSearch extends Rule
{

    /**
     *
     * @var string
     */
    public $name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'safe']
        ];
    }

    /**
     * Search auth item
     * @param array $params
     * @return \yii\data\ActiveDataProvider|\yii\data\ArrayDataProvider
     */
    public function search($params)
    {
        $this->load($params);
        $authManager = Yii::$app->authManager;
        $models = [];
        foreach ($authManager->getRules() as $name => $item) {
            if ($this->name == null || empty($this->name)) {
                $models[$name] = new Rule($item);
            } else if (strpos($name, $this->name) !== FALSE) {
                $models[$name] = new Rule($item);
            }
        }
        return new ArrayDataProvider([
            'allModels' => $models,
        ]);
    }

}