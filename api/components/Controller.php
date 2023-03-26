<?php

namespace api\components;

use api\filters\SystemAppFilter;
use common\filters\FirstRequestTimeFilter;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;

class Controller extends \yii\web\Controller
{
    public  $enableCsrfValidation = false;
    private $_allowedVerbs        = ['GET', 'POST', 'HEAD', 'OPTIONS'];
    private $_allowedHeaders      = ['Content-Type', 'X-Device-firebaseToken', 'X-Device-playerId', 'X-App-Key', 'X-App-Secret', 'X-Device-identifier', 'Authorization'];

    /**
     * Override behaviors from rest controller
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            'corsFilter'             => [
                'class' => \yii\filters\Cors::className(),
                'cors'  => [
                    'Origin'                        => ['*'],
                    'Access-Control-Request-Method' => $this->_allowedVerbs,
                    'Access-Control-Max-Age'        => 3600,
                    'Access-Control-Allow-Headers'  => $this->_allowedHeaders,
                ],
            ],
            'rateLimiter'            => [
                'class'        => \yii\filters\RateLimiter::className(),
                'errorMessage' => \Yii::t('app', 'Too many request'),
            ],
            'contentNegotiator'      => [
                'class'   => ContentNegotiator::class,
                'formats' => [
                    'application/json' => \yii\web\Response::FORMAT_JSON
                ]
            ],
            'verbFilter'             => [
                'class'   => VerbFilter::class,
                'actions' => $this->verbs(),
            ],
            'systemAppFilter'        => [
                'class'              => SystemAppFilter::class,
                'appKeyHeaderKey'    => 'X-App-key',
                'appSecretHeaderKey' => 'X-App-secret'
            ],
            'authenticator'     => [
                'class'       => CompositeAuth::className(),
                'authMethods' => [HttpBearerAuth::className()]
            ],
            'firstRequestTimeFilter' => [
                'class' => FirstRequestTimeFilter::class
            ]
        ];
    }

    /**
     * @param $action
     * @param $result
     *
     * @return mixed
     * @throws HttpException
     */
    public function afterAction($action, $result)
    {
        if (!$result instanceof Response) {
            throw new HttpException(500, 'Response should be instance of \api\components\Response');
        }

        if (($message = $result->validate()) !== true) {
            throw new HttpException(500, $message);
        }

        return parent::afterAction($action, $result);
    }

    /**
     * Declares the allowed HTTP verbs.
     * Please refer to [[VerbFilter::actions]] on how to declare the allowed verbs.
     * @return array the allowed HTTP verbs.
     */
    protected function verbs()
    {
        return [];
    }

    public function init()
    {
        parent::init();
        $lang = \Yii::$app->request->get('lang', null);
        if ($lang) {
            \Yii::$app->language = $lang;
        } else {
            \Yii::$app->language = 'id';

        }
    }
}
