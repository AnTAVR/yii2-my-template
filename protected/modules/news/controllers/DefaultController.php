<?php

namespace app\modules\news\controllers;

use app\modules\news\models\News;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `news` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $query = News::find()->where(['status' => News::STATUS_ACTIVE]);

        $pagination = new Pagination([
            'totalCount' => $query->count(),
            'defaultPageSize' => $this->module->params['pageSize'],
        ]);

        $data = $query->offset($pagination->offset)->limit($pagination->limit)->all();

        return $this->render('index', ['data' => $data, 'pagination' => $pagination,]);
    }

    /**
     * Displays a single News model.
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
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $meta_url
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($meta_url)
    {
        if (($model = News::findOne(['meta_url' => $meta_url, 'status' => News::STATUS_ACTIVE])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
}
