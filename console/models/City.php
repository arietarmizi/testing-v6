<?php

namespace console\models;

use console\models\ActiveRecord;

/**
 * Class City
 *
 * @package console\models
 * @property string $id
 * @property string $provinceId
 * @property string $code
 * @property string $name
 * @property string $description
 * @property string $status
 * @property string $createdAt
 * @property string $updatedAt
 *
 */

class City extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%city}}';
    }
}
