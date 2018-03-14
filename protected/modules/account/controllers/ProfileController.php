<?php

namespace app\modules\account\controllers;

use app\modules\account\models\LoginForm;
use app\modules\account\models\PasswordResetForm;
use app\modules\account\models\PasswordEditForm;
use app\modules\account\models\SignupForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Default controller for the `account` module
 */
class ProfileController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'signup', 'password-reset'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['verify-email'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'logout' => ['post'],
//                ],
//            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm(['scenario' => 'login']);
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            /** @var $identity \app\modules\account\models\User */
            $identity = Yii::$app->user->identity;
            Yii::$app->session->setFlash('success', Yii::t('app', 'Hello {username}', ['username' => $identity->username]));

            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        /** @var $identity \app\modules\account\models\User */
        $identity = Yii::$app->user->identity;

        Yii::$app->user->logout();

        Yii::$app->session->setFlash('success', Yii::t('app', 'Goodbye {username}', ['username' => $identity->username]));

        return $this->goHome();
    }

    /**
     * @return string
     */
    public function actionSignup()
    {
        $model = new SignupForm(['scenario' => 'signup']);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
        }
        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * @return string
     */
    public function actionEdit()
    {
        return $this->render('edit');
    }

    /**
     * @return string
     */
    public function actionPasswordReset()
    {
        $model = new PasswordResetForm(['scenario' => 'password-reset']);

        if ($model->load(Yii::$app->request->get()) && $model->validate()) {
            $model->save();
        }
        return $this->render('password-reset', [
            'model' => $model,
        ]);
    }

    /**
     * @return string
     */
    public function actionPasswordEdit()
    {
        $model = new PasswordEditForm(['scenario' => 'password-edit']);

        if ($model->load(Yii::$app->request->get()) && $model->validate()) {
            $model->save();
        }
        return $this->render('password-edit', [
            'model' => $model,
        ]);
    }

    /**
     * @param $user_id integer
     * @param $crc string
     * @return string
     */
    public function actionVerifyEmail(/** @noinspection PhpUnusedParameterInspection */
        $user_id, $crc)
    {
        return (string)$user_id . ' ' . (string)$crc;
    }
}
