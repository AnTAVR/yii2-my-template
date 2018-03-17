<?php

namespace app\modules\account\controllers;

use app\modules\account\models\LoginForm;
use app\modules\account\models\User;
use Yii;
use yii\db\Expression;
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
            $user = User::findOne(['username' => $model->username]);
            if ($user->status == User::STATUS_ACTIVE) {
                $login = Yii::$app->user->login($user, $model->rememberMe ? $this->module->params['duration'] : 0);
                if ($login) {
                    $user->session = Yii::$app->session->id;
                    $user->session_at = new Expression('NOW()');
                    $user->save();

                    Yii::$app->session->addFlash('success', Yii::t('app', 'Hello {username}', ['username' => $user->username]));
                    return $this->goBack();
                }
            } else {
                $model->addError('username', Yii::t('app', 'User "{username}" status: "{status}"', ['username' => $user->username, 'status' => $user->getStatusName()]));
            }
        }
        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
