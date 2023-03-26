<?php
/**
 * Created by PhpStorm.
 * User: Nadzif Glovory
 * Date: 8/29/2018
 * Time: 4:42 PM
 */

namespace common\translation;

use yii\db\ActiveRecord;

/**
 * Class Message
 *
 * @package common\translation
 * @property integer $id
 * @property string  $language
 * @property string  $translation
 */
class Message extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%message}}';
    }

}