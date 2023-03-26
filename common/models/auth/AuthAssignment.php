<?php
/**
 * Created by PhpStorm.
 * User: Bambang
 * Date: 11/05/2021
 * Time: 20:13
 */

namespace common\models\auth;

use common\base\ActiveRecord;

/**
 *
 * Class AuthAssignment
 *
 * @package common\models
 *
 * @property string $item_name
 * @property string $user_id
 * @property string $created_at
 *
 *
 */
class AuthAssignment extends ActiveRecord
{

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    public static function getDb()
    {
        return \Yii::$app->db;
    }

    public static function tableName()
    {
        return '{{%auth_assignment}}';
    }

    public function rules()
    {
        $rules = parent::rules();
        return $rules;
    }
}
