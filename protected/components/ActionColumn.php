<?php

namespace app\components;

use Yii;
use yii\grid\ActionColumn as OldActionColumn;
use yii\helpers\Html;

class ActionColumn extends OldActionColumn
{
    protected function initDefaultButton($name, $iconName, $additionalOptions = [])
    {
        if (!isset($this->buttons[$name]) && strpos($this->template, '{' . $name . '}') !== false) {
            $this->buttons[$name] = function (/** @noinspection PhpUnusedParameterInspection */
                $url, $model, $key) use ($name, $iconName, $additionalOptions) {
                $class = 'default';
                switch ($name) {
                    case 'view':
                        $title = Yii::t('yii', 'View');
                        break;
                    case 'update':
                        $title = Yii::t('yii', 'Update');
                        break;
                    case 'delete':
                        $title = Yii::t('yii', 'Delete');
                        $class = 'danger';
                        break;
                    default:
                        $title = ucfirst($name);
                }
                $options = array_merge([
                    'title' => $title,
                    'aria-label' => $title,
                    'data-pjax' => '0',
                    'class' => 'btn btn-sm btn-' . $class,
                ], $additionalOptions, $this->buttonOptions);
                $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-$iconName"]);
                return Html::a($icon, $url, $options);
            };
        }
    }

}
