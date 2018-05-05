<?php

namespace app\modules\news\widgets;

use app\modules\news\models\News;
use Yii;
use yii\bootstrap\Widget;
use yii\helpers\Html;
use yii\widgets\Menu;

class NewsMenu extends Widget
{

    public function run()
    {
        $itemsMenu = [];
        foreach ($this->findModel() as $model) {
            /* @var $model News */
            $itemsMenu[] = ['label' => $model->content_title, 'url' => $model->arrUrl];
        }

        if (!$itemsMenu) return '';

        $text = '<div class="sidebar-module sidebar-news">';
        $text .= '<h4>' . Html::a(Yii::t('app', 'News'), ['/news']) . '</h4>';
        $text .= Menu::widget([
            'options' => ['class' => 'list-unstyled'],
            'items' => $itemsMenu,
        ]);
        $text .= '</div>';

        return $text;
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