<?php

namespace common\models;

use common\base\ActiveRecord;

/**
 * Class SystemApp
 *
 * @package common\models
 *
 * @property string $id
 * @property string $partnerId
 * @property string $name
 * @property string $appKey
 * @property string $appSecret
 * @property string $type
 * @property string $ip
 * @property string $status
 * @property string $createdAt
 * @property string $updatedAt
 */
class SystemApp extends ActiveRecord
{

    const STATUS_ACTIVE   = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_BLOCKED  = 'blocked';

    const TYPE_DEVICE   = 'device';
    const TYPE_SERVICE  = 'service';
    const TYPE_EXTERNAL = 'external';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%system_app}}';
    }
}
