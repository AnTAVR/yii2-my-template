<?php

namespace app\controllers;

use app\models\StaticPage;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class StaticController extends Controller
{

    /**
     * Displays a single StaticPage model.
     * @param string $meta_url
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex($meta_url = 'index')
    {
        /** @noinspection RequireParameterInspection */
        return $this->render('index', [
            'model' => self::findModel($meta_url),
        ]);
    }

    /**
     * Finds the StaticPage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $meta_url
     * @return StaticPage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    static function findModel($meta_url)
    {
        if (($model = StaticPage::findOne(['meta_url' => $meta_url])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
}
