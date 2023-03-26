<?php

namespace api\filters;

use api\components\HttpException;
use common\models\SystemApp;
use yii\base\ActionFilter;
use yii\base\InvalidConfigException;

class SystemAppFilter extends ActionFilter
{
    public $appKeyHeaderKey;
    public $appSecretHeaderKey;

    /**
     * @since 2018-02-13 14:07:03
     *
     * @param \yii\base\Action $action
     *
     * @return bool
     * @throws HttpException
     * @throws InvalidConfigException
     */
    public function beforeAction($action)
    {
        if (empty($this->appKeyHeaderKey) || empty($this->appSecretHeaderKey)) {
            throw new InvalidConfigException('Please setup $appKeyHeaderKey and $appSecretHeaderKey when using this class as filter.');
        }

        $appKey    = \Yii::$app->request->headers->get($this->appKeyHeaderKey);
        $appSecret = \Yii::$app->request->headers->get($this->appSecretHeaderKey);

        if (empty($appKey) || empty($appSecret)) {
            throw new HttpException(400, 'Please provide the security of app key and app secret');
        }

        /** @var SystemApp $systemApp */
        $systemApp = SystemApp::find()
            ->where([
                'appKey'    => $appKey,
                'appSecret' => $appSecret
            ])
            ->one();

        if (empty($systemApp)) {
            throw new HttpException(400, 'Either one or both of your app key and app secret is invalid.');
        }

        if ($systemApp->status !== SystemApp::STATUS_ACTIVE) {
            throw new HttpException(400, 'Your app status is ' . $systemApp->status . '. Please contact help desk.');
        }

        if(!empty($systemApp->ip) && $systemApp->ip != \Yii::$app->request->getUserIP()) {
            throw new HttpException(400, 'Your app can only be accessed from specific IP.');
        }

        // set it in the container
        \Yii::$app->set('systemApp', $systemApp);

        return true;
    }
}
