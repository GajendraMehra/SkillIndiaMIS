<?php


namespace frontend\models;
use yii\db\ActiveRecord;
use yii\base\Behavior;

class TrimBehavior extends Behavior
{

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
        ];
    }

    public function beforeValidate($event)
    {
        $attributes = $this->owner->attributes;
        foreach($attributes as $key => $value) { //For all model attributes
            $this->owner->$key = trim($this->owner->$key);
            $this->owner->$key = strip_tags($this->owner->$key);
           
            
        }
        // die;
        
    }



}
