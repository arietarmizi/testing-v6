<?php
/**
 * Created by PhpStorm.
 * User: Nadzif Glovory
 * Date: 5/25/2018
 * Time: 1:02 AM
 */

namespace api\components;


use common\models\SystemConfig;
use paragraph1\phpFCM\Recipient\Topic;
use understeam\fcm\Client;

class Firebase extends Client
{
    const CLICK_ACTION_FCM     = 'FCM_PLUGIN_ACTIVITY';
    const CLICK_ACTION_FLUTTER = 'FLUTTER_NOTIFICATION_CLICK';

    const ICON_DEFAULT = 'notification_icon_resource_name';

    public $module;
    public $lightColor = '#FF0000';

    public function init()
    {
        parent::init();
        $this->apiKey = SystemConfig::getValueWithFallback(SystemConfig::FIREBASE_TOKEN, null);

        if ($this->apiKey == null) {
            throw new HttpException(400, 'Please provide firebase token');
        }
    }

    public function send($sender, $recipient, $title, $message, $data = [])
    {

    }
}