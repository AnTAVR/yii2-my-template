<?php

namespace app\modules\products\models\searches;

use app\modules\products\models\Category;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class CategorySearch extends Model
{
    /**
     *
     * @var integer $id
     */
    public $id;

    /**
     *
     * @var string $meta_url
     */
    public $meta_url;

    /**
     *
     * @var string $content_title
     */
    public $content_title;

    public function rules()
    {
        return [
            ['id', 'safe'],
            ['meta_url', 'safe'],
            ['content_title', 'safe'],
        ];
    }

    public function attributeLabels()
    {
        $model = new Category();
        return $model->attributeLabels();
    }

    /**
     * Create data provider for Assignment model.
     */
    public function search()
    {
        $query = Category::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => Yii::$app->modules['products']->params['adminPageSize'],
            ],
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC,],
            ],
        ]);
        $params = Yii::$app->request->getQueryParams();

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like', 'meta_url', $this->meta_url]);
        $query->andFilterWhere(['like', 'content_title', $this->content_title]);

        return $dataProvider;
    }
}
