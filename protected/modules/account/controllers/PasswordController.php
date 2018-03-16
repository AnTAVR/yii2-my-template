<?php

namespace app\modules\account\controllers;

use app\modules\account\models\PasswordResetForm;
use app\modules\account\models\SignupForm;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PasswordController extends Controller
{
    public function behaviors()
    {
        $behaviors = [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'new'],
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
        return ArrayHelper::merge(parent::behaviors(), $behaviors);
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $model = new PasswordResetForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->addFlash('success', Yii::t('app', 'A letter with instructions was sent to E-Mail.'));
            } else {
                Yii::$app->session->addFlash('error', Yii::t('app', 'There was an error sending email.'));
            }
            return $this->goHome();
        }
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * @param $user_id integer
     * @param $token string
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionNew($user_id, $token)
    {
        $user = SignupForm::findOne($user_id);
        if (!$user) {
            throw new NotFoundHttpException(Yii::t('app', 'User not found.'));
        }

        if (!$user->validateEmailToken($token)) {
            throw new NotFoundHttpException(Yii::t('app', 'User not found.'));
        }
        $user->verifyEmail();
        Yii::$app->session->addFlash('success', Yii::t('app', 'E-Mail is verified, now you can login.'));
        return $this->redirect(Yii::$app->user->loginUrl);
    }
}
