<?php

namespace app\modules\articles\widgets;

use app\modules\articles\models\Articles;
use Yii;
use yii\bootstrap\Widget;
use yii\helpers\Html;
use yii\widgets\Menu;

class ArticlesMenu extends Widget
{

    public function run()
    {
        $itemsMenu = [];
        foreach ($this->findModel() as $model) {
            /* @var $model Articles */
            $itemsMenu[] = ['label' => $model->content_title, 'url' => $model->arrUrl];
        }

        if (!$itemsMenu) return '';

        $text = '<div class="sidebar-module sidebar-articles">';
        $text .= '<h4>' . Html::a(Yii::t('app', 'Articles'), ['/articles']) . '</h4>';
        $text .= Menu::widget([
            'options' => ['class' => 'list-unstyled'],
            'items' => $itemsMenu,
        ]);
        $text .= '</div>';

        return $text;
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