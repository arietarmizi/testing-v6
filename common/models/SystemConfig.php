<?php

namespace common\models;

use common\base\ActiveRecord;

/**
 * Class SystemConfig
 *
 * @package common\models\core
 *
 * @property string $id
 * @property string $key
 * @property string $value
 * @property string $createdAt
 * @property string $updatedAt
 */
class SystemConfig extends ActiveRecord
{
    /** Timezone default for the user. Server timezone is always UTC. */
    const USER_DEFAULT_TIMEZONE = 'userDefaultTimezone';
    const FIREBASE_TOKEN        = 'firebaseToken';

    public static function tableName()
    {
        return '{{%system_config}}';
    }

    /**
     * Create or edit existing config based on the key
     *
     * @param $key
     * @param $value
     *
     * @return \common\models\SystemConfig|null|static
     */
    public static function createOrEdit($key, $value)
    {
        $config = self::findOne([
            'key' => $key
        ]);

        if ($config === null) {
            $config      = new SystemConfig();
            $config->key = $key;
        }

        $config->value = $value;
        $config->save();

        return $config;
    }

    /**
     * Get value based on the key, with fallback value if not found.
     * Fallback also work event the db is not exists.
     *
     * @param $key
     * @param $fallback
     *
     * @return string
     */
    public static function getValueWithFallback($key, $fallback)
    {
        $config = self::findOne([
            'key' => $key
        ]);

        if ($config === null) {
            return $fallback;
        }

        return $config->value;
    }
}
