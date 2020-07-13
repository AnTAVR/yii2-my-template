<?php

namespace app\modules\products\widgets;

use app\modules\products\models\Category;
use app\modules\products\models\Products;
use Yii;
use yii\bootstrap\Widget;
use yii\widgets\Menu;

class ProductsNav extends Widget
{

    public function run()
    {
        $itemsMenu = [];
        foreach ($this->findModel() as $model) {
            /* @var $model Category */
            $itemsMenu[] = ['label' => $model->content_title . ' (' . $model->count . ')', 'url' => $model->arrUrl,
                'options' => ['class' => 'dropdown-header']
            ];
            foreach ($model->product as $product) {
                Yii::error(serialize($product));
                /* @var $product Products */
                $itemsMenu[] = ['label' => $product->content_title, 'url' => $product->arrUrl];
            }
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
        if (($model = Category::find()
                ->orderBy(['published_at' => SORT_DESC, 'id' => SORT_ASC])
                ->limit(10)->all()) !== null
        ) {
            return $model;
        }
        return [];
    }

}