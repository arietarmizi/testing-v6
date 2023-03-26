<?php


namespace api\controllers;


use api\components\Controller;
use api\components\FormAction;
use api\config\ApiCode;
use api\filters\ContentTypeFilter;
use api\forms\auth\LoginForm;
use api\forms\auth\RegisterForm;

class AuthController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
//
        $behaviors['authenticator']['except'] = [
            'login',
            'register',
        ];

        $behaviors['content-type-filter'] = [
            'class'       => ContentTypeFilter::class,
            'contentType' => ContentTypeFilter::TYPE_APPLICATION_JSON,
            'only'        => [
                'register',
                'login',
                'logout'
            ]
        ];
        return $behaviors;
    }

    public function actions()
    {
        return [
            'register' => [
                'class'          => FormAction::class,
                'formClass'      => RegisterForm::class,
                'messageSuccess' => \Yii::t('app', 'Register User Success.'),
                'messageFailed'  => \Yii::t('app', 'Register User Failed.'),
                'apiCodeSuccess' => ApiCode::DEFAULT_SUCCESS_CODE,
                'apiCodeFailed'  => ApiCode::DEFAULT_FAILED_CODE,
            ],
            'login'    => [
                'class'          => FormAction::class,
                'formClass'      => LoginForm::class,
                'messageSuccess' => \Yii::t('app', 'Login Success.'),
                'messageFailed'  => \Yii::t('app', 'Login Failed.'),
                'apiCodeSuccess' => ApiCode::DEFAULT_SUCCESS_CODE,
                'apiCodeFailed'  => ApiCode::DEFAULT_FAILED_CODE,
                'statusSuccess'  => 200,
                'statusFailed'   => 400,
            ],
        ];
    }

    public function verbs()
    {
        return [
            'register' => ['post'],
            'login'    => ['post'],
        ];
    }
}