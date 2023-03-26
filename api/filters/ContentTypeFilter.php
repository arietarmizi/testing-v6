<?php

namespace api\filters;

use api\components\HttpException;
use yii\base\ActionFilter;
use yii\web\JsonParser;

/**
 * Class ContentTypeFilter
 * @package api\filters
 */
class ContentTypeFilter extends ActionFilter
{
    const TYPE_APPLICATION_JSON = 'application/json';

    public $parsers = [
        self::TYPE_APPLICATION_JSON => JsonParser::class
    ];

    public $contentType;

    /**
     * @since 2018-02-23 14:54:21
     *
     * @param \yii\base\Action $action
     *
     * @return bool
     * @throws HttpException
     */
    public function beforeAction($action)
    {
        $contentType = \Yii::$app->request->contentType;
        if(\strpos($contentType, ';')) {
            $contentType = \strstr(\Yii::$app->request->contentType, ';', true);
        }

        if ($contentType != $this->contentType) {
            throw new HttpException(400, 'Can only consume: ' . $this->contentType. 'Your request was ' . $contentType);
        }

        if(\array_key_exists($this->contentType, $this->parsers)) {
            \Yii::$app->request->parsers = $this->parsers;
        }

        return parent::beforeAction($action);
    }
}
