<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_attendance_label".
 *
 * @property int $id
 * @property string $label_name
 */
class AttendanceLabel extends \yii\db\ActiveRecord
{
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
    public static function tableName()
    {
        return 'tbl_attendance_label';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['label_name'], 'required'],
            [['label_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'label_name' => 'Label Name',
        ];
    }
}
