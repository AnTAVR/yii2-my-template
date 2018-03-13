<?php

namespace app\modules\user\controllers;

use app\modules\user\models\LoginForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Default controller for the `user` module
 */
class ProfileController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['login', 'logout', 'signup', 'index', 'edit'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'signup'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout', 'index', 'edit'],
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

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            /** @var $identity \app\modules\user\models\User */
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
        /** @var $identity \app\modules\user\models\User */
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
        return $this->render('signup');
    }

    /**
     * @return string
     */
    public function actionEdit()
    {
        return $this->render('edit');
    }
}
