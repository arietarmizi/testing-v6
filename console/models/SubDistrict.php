<?php

namespace console\models;

use console\models\ActiveRecord;

/**
 * Class SubDistrict
 *
 * @package console\models
 * @property string $id
 * @property string $districtId
 * @property string $name
 * @property string $description
 * @property string $postalCode
 * @property string $status
 * @property string $createdAt
 * @property string $updatedAt
 *
 */

class SubDistrict extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%sub_district}}';
    }
}
