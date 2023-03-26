<?php

namespace common\base;

use Ramsey\Uuid\Uuid;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * Class ActiveRecord
 *
 * @package common\base
 * @author  Haqqi <me@haqqi.net>
 *
 */
class ActiveRecord extends \yii\db\ActiveRecord
{
    public static function tableColumns()
    {
        $columnNames = self::getTableSchema()->getColumnNames();

        $columnWithTableName = [];
        foreach ($columnNames as $columnName) {
            $columnWithTableName[] = self::tableName() . '.' . $columnName;
        }

        return $columnWithTableName;
    }

    /**
     * Default behaviors for all models in this project
     *
     * @return array
     */

    public function behaviors()
    {
        $behaviors = [];

        $behaviors['timestampBehavior'] = [
            'class'              => TimestampBehavior::class,
            'value'              => new Expression("'" . date('Y-m-d H:i:s') . "'"),
            'createdAtAttribute' => 'createdAt',
            'updatedAtAttribute' => 'updatedAt'
        ];

        $behaviors['uuid'] = [
            'class'      => AttributeBehavior::class,
            'value'      => function ($event) {
                return Uuid::uuid4()->toString();
            },
            'attributes' => [
                ActiveRecord::EVENT_BEFORE_INSERT => ['id']
            ],
        ];

        return $behaviors;
    }
}
