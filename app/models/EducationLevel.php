<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_education_level".
 *
 * @property int $id
 * @property string $education
 */
class EducationLevel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_education_level';
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
            [['education'], 'required'],
            [['education'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'education' => 'Education',
        ];
    }
}
