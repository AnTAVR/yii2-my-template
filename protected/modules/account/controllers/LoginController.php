<?php

namespace app\modules\account\controllers;

use app\modules\account\models\LoginForm;
use Yii;
use yii\web\Controller;

class LoginController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->login()) {
                /** @var \app\modules\account\models\User $identity */
                $identity = Yii::$app->user->identity;
                Yii::$app->session->addFlash('success', Yii::t('app', 'Hello {username}', ['username' => $identity->username]));
                return $this->goBack();
            }
        }
        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
