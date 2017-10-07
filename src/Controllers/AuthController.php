<?php

namespace frenna\auth\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frenna\auth\models\LoginForm;

class AuthController extends Controller
{

    public function behaviors()
    {   
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allows'  => ['true'],
                        'roles'   => ['@'],
                    ],                    
                ],
            ],

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ]
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionLogin()
    {
        if(Yii::$app->user->isGuest) {
            $loginForm = new LoginForm();
            $post = Yii::$app->request->post();

            if($loginForm->load($post) && $loginForm->login()) {
                return $this->goBack();
            }

            return $this->render('auth/login', [
                "model" => $loginForm
            ]);
        }

        return $this->goHome();

    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
