<?php

namespace app\modules\articles\controllers;

use app\modules\articles\models\Articles;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `articles` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $query = Articles::find()->where(['status' => Articles::STATUS_ACTIVE]);

        $pagination = new Pagination([
            'totalCount' => $query->count(),
            'defaultPageSize' => $this->module->params['pageSize'],
        ]);

        $data = $query->offset($pagination->offset)->limit($pagination->limit)->all();

        return $this->render('index', ['data' => $data, 'pagination' => $pagination,]);
    }

    /**
     * Displays a single Articles model.
     * @param string $meta_url
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($meta_url)
    {
        return $this->render('view', [
            'model' => $this->findModel($meta_url),
        ]);
    }

    /**
     * Finds the Articles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $meta_url
     * @return Articles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($meta_url)
    {
        if (($model = Articles::findOne(['meta_url' => $meta_url, 'status' => Articles::STATUS_ACTIVE])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
}
