<?php

namespace console\models;

use console\models\ActiveRecord;

/**
 * Class District
 *
 * @package console\models
 * @property string $id
 * @property string $cityId
 * @property string $name
 * @property string $description
 * @property string $status
 * @property string $createdAt
 * @property string $updatedAt
 *
 */

class District extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%district}}';
    }
}
