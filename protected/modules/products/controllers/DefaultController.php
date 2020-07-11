<?php

namespace app\modules\products\controllers;

use app\modules\products\models\Products;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class DefaultController extends Controller
{
    /**
     * Lists all Products models.
     * @param string $meta_url
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex($meta_url = null)
    {
        $query = Products::find()->where(['status' => Products::STATUS_ACTIVE]);

        $pagination = new Pagination([
            'totalCount' => $query->count(),
            'defaultPageSize' => $this->module->params['pageSize'],
            'validatePage' => false,
            'pageSizeLimit' => false,
        ]);

        if ($pagination->page >= $pagination->pageCount) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }

        $data = $query->offset($pagination->offset)->limit($pagination->limit)->all();

        return $this->render('index', ['data' => $data, 'pagination' => $pagination,]);
    }

    /**
     * Displays a single Products model.
     * @param string $meta_url
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($meta_url)
    {
        return $this->render('view', [
            'model' => $this->findModel($meta_url),
        ]);
    }

    /**
     * @param string $meta_url
     * @return Products the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($meta_url)
    {
        if (($model = Products::findOne(['meta_url' => $meta_url, 'status' => Products::STATUS_ACTIVE])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
