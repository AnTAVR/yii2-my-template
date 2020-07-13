<?php

namespace app\modules\articles\widgets;

use app\modules\articles\models\Articles;
use yii\bootstrap\Widget;
use yii\widgets\Menu;

class ArticlesNav extends Widget
{

    public function run()
    {
        $itemsMenu = [];
        foreach ($this->findModel() as $model) {
            /* @var $model Articles */
            $itemsMenu[] = ['label' => $model->content_title, 'url' => $model->arrUrl];
        }

        if (!$itemsMenu) return '';

        return Menu::widget([
            'options' => ['class' => 'dropdown-menu'],
            'items' => $itemsMenu,
        ]);
    }

    protected function findModel()
    {
        if (($model = Articles::find()
                ->where(['status' => Articles::STATUS_ACTIVE])
                ->orderBy(['published_at' => SORT_DESC, 'id' => SORT_ASC])
                ->limit(10)->all()) !== null
        ) {
            return $model;
        }
        return [];
    }

}