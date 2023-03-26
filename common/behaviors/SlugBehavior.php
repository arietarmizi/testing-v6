<?php

namespace common\behaviors;

use yii\db\ActiveRecord;

class SlugBehavior extends \yii\base\Behavior
{

    public $isUnique      = false;
    public $targetClass;
    public $slugAttribute = 'slug';
    public $attribute;

    public function getSlug($text)
    {
        /** @todo make function to get slug */
        return time();
    }


    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'setSlugAttribute',
        ];
    }

    public function setSlugAttribute()
    {
        $slugAttribute = $this->slugAttribute;
        if (!$this->owner->$slugAttribute) {
            $attribute = $this->attribute;
            $this->owner->$slugAttribute = $this->getSlug($this->owner->$attribute);
        }
    }
}
