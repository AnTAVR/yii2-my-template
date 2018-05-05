<?php

namespace app\modules\products\widgets;

use app\modules\products\models\Products;
use Yii;
use yii\bootstrap\Widget;
use yii\helpers\Html;
use yii\widgets\Menu;

class ProductsMenu extends Widget
{

    public function run()
    {
        $itemsMenu = [];
        foreach ($this->findModel() as $model) {
            /* @var $model Products */
            $itemsMenu[] = ['label' => $model->content_title, 'url' => $model->arrUrl];
        }

        if (!$itemsMenu) return '';

        $text = '<div class="sidebar-module sidebar-products">';
        $text .= '<h4>' . Html::a(Yii::t('app', 'Products'), ['/products']) . '</h4>';
        $text .= Menu::widget([
            'options' => ['class' => 'list-unstyled'],
            'items' => $itemsMenu,
        ]);
        $text .= '</div>';

        return $text;
    }

    protected function findModel()
    {
        if (($model = Products::find()
                ->where(['status' => Products::STATUS_ACTIVE])
                ->orderBy(['published_at' => SORT_DESC, 'id' => SORT_ASC])
                ->limit(10)->all()) !== null
        ) {
            return $model;
        }
        return [];
    }

}