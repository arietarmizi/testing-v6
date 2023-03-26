<?php

use api\components\ErrorHandler;
use yii\web\Response;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id'                  => 'app-api',
    'name'                => 'Power Monitoring Program',
    'basePath'            => dirname(__DIR__),
    'bootstrap'           => ['log'],
    'controllerNamespace' => 'api\controllers',
    'components'          => [
        'request'      => [
            'enableCookieValidation' => false,
            'enableCsrfCookie'       => false,
            'enableCsrfValidation'   => false
        ],
        'user'         => [
            'identityClass'   => \common\models\User::class,
            'enableAutoLogin' => true,
            'identityCookie'  => ['name' => '_identity-api-user', 'httpOnly' => true],
            'loginUrl'        => ['auth/login']
        ],
        'response'     => [
            'format' => Response::FORMAT_JSON
        ],
        'log'          => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'class' => ErrorHandler::class,
        ],
        'urlManager'   => [
            'enablePrettyUrl'     => true,
            'showScriptName'      => false,
            'enableStrictParsing' => true,
            'rules'               => require(__DIR__ . DIRECTORY_SEPARATOR . 'routes.php'),
        ],

    ],
    'params'              => $params,
];
