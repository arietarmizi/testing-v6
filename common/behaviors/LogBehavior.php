<?php
/**
 * Created by PhpStorm.
 * User: Nadzif Glovory
 * Date: 4/1/2018
 * Time: 12:25 PM
 */

namespace common\behaviors;


use common\models\SystemLog;
use common\base\ActiveRecord;
use yii\base\Behavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use common\models\AppLog;
use common\components\Hasher;

class LogBehavior extends Behavior
{
    public  $_information;
    public  $_refCode = null;
    private $dataBefore;

    private $attributes = [];

    private static function getClientIp()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP')) {
            $ipaddress = getenv('HTTP_CLIENT_IP');
        } else {
            if (getenv('HTTP_X_FORWARDED_FOR')) {
                $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
            } else {
                if (getenv('HTTP_X_FORWARDED')) {
                    $ipaddress = getenv('HTTP_X_FORWARDED');
                } else {
                    if (getenv('HTTP_FORWARDED_FOR')) {
                        $ipaddress = getenv('HTTP_FORWARDED_FOR');
                    } else {
                        if (getenv('HTTP_FORWARDED')) {
                            $ipaddress = getenv('HTTP_FORWARDED');
                        } else {
                            if (getenv('REMOTE_ADDR')) {
                                $ipaddress = getenv('REMOTE_ADDR');
                            } else {
                                $ipaddress = 'UNKNOWN';
                            }
                        }
                    }
                }
            }
        }
        return $ipaddress;
    }

    public function init()
    {
        if (!\Yii::$app->request->isConsoleRequest) {
            $this->attributes['userAgent']     = \Yii::$app->request->userAgent;
            $this->attributes['userIp']        = \Yii::$app->request->userIP;
            $this->attributes['userHost']      = \Yii::$app->request->userHost;
            $this->attributes['url']           = \Yii::$app->request->url;
            $this->attributes['portRequest']   = \Yii::$app->request->port;
            $this->attributes['hostInfo']      = \Yii::$app->request->hostInfo;
            $this->attributes['hostName']      = \Yii::$app->request->hostName;
            $this->attributes['identityClass'] = \Yii::$app->user->identityClass;

            if (!\Yii::$app->user->isGuest) {
                $this->attributes['identityId'] = \Yii::$app->user->id;

            }
        }

    }

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT  => 'createRecord',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'updateRecord',
            ActiveRecord::EVENT_BEFORE_DELETE => 'deleteRecord',
        ];
    }

    public function setOldAttributes()
    {
        $this->dataBefore = Json::encode($this->getAttributes());
    }

    private function getAttributes()
    {
        return $this->owner->getAttributes();
    }

    public function createRecord()
    {
        return $this->behaviorRecord(SystemLog::ACTION_INSERT);
    }

    public function behaviorRecord($action)
    {
        $dataBefore = Json::encode($this->getOldAttributes());
        $dataAfter  = Json::encode($this->getAttributes());

        /** @var ActiveRecord $owner */
        $owner = $this->owner;

        $appLog = new SystemLog(ArrayHelper::merge([
            'code'               => $this->_refCode,
            'modelId'            => $owner->id,
            'modelClass'         => $owner->className(),
            'action'             => $action,
            'isAttributeChanged' => $dataBefore == $dataAfter,
            'attributeBefore'    => $dataBefore,
            'attributeAfter'     => $dataAfter,
            'information'        => $this->_information,
        ], $this->attributes));

        return $appLog->save();
    }

    private function getOldAttributes()
    {
        return $this->owner->getOldAttributes();
    }


    public function updateRecord()
    {
        return $this->behaviorRecord(SystemLog::ACTION_UPDATE);
    }

    public function deleteRecord()
    {
        return $this->behaviorRecord(SystemLog::ACTION_DELETE);
    }

}
