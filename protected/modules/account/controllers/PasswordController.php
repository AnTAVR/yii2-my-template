<?php

namespace app\modules\account\controllers;

use app\modules\account\models\PasswordForm;
use app\modules\account\models\PasswordNewForm;
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
        $model = new PasswordForm();

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
        $model = PasswordNewForm::findOne($user_id);
        if (!$model) {
            throw new NotFoundHttpException(Yii::t('app', 'User not found.'));
        }

        if (!$model->validatePasswordToken($token)) {
            throw new NotFoundHttpException(Yii::t('app', 'User not found.'));
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->edit();
            Yii::$app->session->addFlash('success', Yii::t('app', 'New password was saved.'));
            return $this->redirect(Yii::$app->user->loginUrl);
        }
        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
