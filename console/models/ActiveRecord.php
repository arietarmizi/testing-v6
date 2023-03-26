<?php

namespace console\models;

use common\base\ActiveRecord as BaseActiveRecord;
use Ramsey\Uuid\Uuid;

class ActiveRecord extends BaseActiveRecord
{
    public static function tableName()
    {
        $prefix = '';
        $curdb  = explode('=', \Yii::$app->dbPayment->dsn);
        $dbName = $curdb[2];
        if (self::getDb()->driverName == 'sqlsrv') {
            $prefix = $dbName . '.{{dbo}}.';
        } else {
            $prefix = $dbName . '.';
        }
        return $prefix . '{{%province}}';
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['uuid']);

        return $behaviors;
    }

    public function rules()
    {
        $rules   = parent::rules();
        $rules[] = [['name'], 'unique'];

        return $rules;
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if (!$this->id) {
            $this->id = Uuid::uuid4()->toString();
        }

        return parent::save($runValidation, $attributeNames);
    }
}
