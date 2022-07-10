<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_religion".
 *
 * @property int $id
 * @property string $religion_name
 */
class Religion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_religion';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TrimBehavior::className(),
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['religion_name'], 'required'],
            [['religion_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'religion_name' => 'Religion Name',
        ];
    }
}
