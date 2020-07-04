<?php

namespace app\modules\statics\controllers;

use app\modules\statics\models\StaticPage;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class DefaultController extends Controller
{

    /**
     * Displays a single StaticPage model.
     * @param string $meta_url
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex($meta_url = null)
    {
        return $this->render('index', [
            'model' => self::findModel($meta_url),
        ]);
    }

    /**
     * @param string $meta_url
     * @return StaticPage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    static function findModel($meta_url)
    {
        if (($model = StaticPage::findOne(['meta_url' => $meta_url])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
