<?php

namespace app\modules\news\widgets;

use app\modules\news\models\News;
use yii\bootstrap\Widget;
use yii\widgets\Menu;

class NewsNav extends Widget
{

    public function run()
    {
        $itemsMenu = [];
        foreach ($this->findModel() as $model) {
            /* @var $model News */
            $itemsMenu[] = ['label' => $model->content_title, 'url' => $model->arrUrl];
        }

        if (!$itemsMenu)
            return '';

        return Menu::widget([
            'options' => ['class' => 'dropdown-menu'],
            'items' => $itemsMenu,
        ]);
    }

    protected function findModel()
    {
        if (($model = News::find()
                ->where(['status' => News::STATUS_ACTIVE])
                ->orderBy(['published_at' => SORT_DESC, 'id' => SORT_ASC])
                ->limit(10)->all()) !== null
        ) {
            return $model;
        }
        return [];
    }

}