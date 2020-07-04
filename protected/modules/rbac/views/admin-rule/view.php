<?php

use app\modules\rbac\models\Role;
use yii\web\View;

/* @var $this View */
/* @var $model Role */

?>
<table class="table table-striped table-bordered detail-view">
    <tbody>
    <tr>
        <th><?= $model->attributeLabels()['name'] ?></th>
        <td><?= $model->name ?></td>
    </tr>
    <tr>
        <th><?= $model->attributeLabels()['className'] ?></th>
        <td><?= $model->className ?></td>
    </tr>
    </tbody>
</table>
