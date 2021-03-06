<?php

namespace app\modules\rbac\models\searches;

use app\modules\account\models\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class AssignmentSearch extends Model
{
    /**
     *
     * @var integer $id
     */
    public $id;

    /**
     *
     * @var string $login
     */
    public $username;

    public function rules()
    {
        return [
            ['id', 'safe'],
            ['username', 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
        ];
    }

    /**
     * Create data provider for Assignment model.
     */
    public function search()
    {
        $query = User::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $params = Yii::$app->request->getQueryParams();

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like', 'username', $this->username]);

        return $dataProvider;
    }

}
