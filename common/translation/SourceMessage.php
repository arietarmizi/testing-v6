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
 * Class SourceMessage
 *
 * @package common\transalation
 * @property integer $id
 * @property string  $category
 * @property string  $message
 *
 * @property Message $indonesiaLanguage
 */
class SourceMessage extends ActiveRecord
{

    public $indonesiaTranslation;

    public static function tableName()
    {
        return '{{%source_message}}';
    }


    public function getIndonesiaLanguage()
    {
        return $this->hasOne(Message::className(), ['id' => 'id'])->andWhere(['language' => 'id']);
    }


}