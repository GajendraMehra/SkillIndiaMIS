<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_student_attendance".
 *
 * @property int $id
 * @property int $batch_id
 * @property string $attendance_data
 */
class StudentAttendance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_student_attendance';
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
            [['batch_id', 'attendance_data'], 'required'],
            [['batch_id'], 'integer'],
            [['attendance_data'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'batch_id' => 'Batch ID',
            'attendance_data' => 'Attendance Data',
        ];
    }
}
