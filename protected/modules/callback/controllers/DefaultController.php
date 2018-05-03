<?php

namespace app\modules\callback\controllers;

use app\modules\callback\models\forms\CallbackForm;
use Yii;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $model = new CallbackForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->addFlash('success', Yii::t('app', 'Thank you for contacting us.') . ' ' . Yii::t('app', 'We will respond to you as soon as possible.'));
            } else {
                Yii::$app->session->addFlash('error', Yii::t('app', 'There was an error sending email.'));
            }

            return $this->refresh();
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
