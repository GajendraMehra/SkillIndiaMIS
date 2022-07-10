<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "student_result".
 *
 * @property int $id
 * @property int $batch_id
 * @property int $student_id
 * @property int $result
 */
class StudentResult extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'student_result';
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
            [['batch_id', 'student_id', 'result',], 'required'],
            [['batch_id','reclaim','result1','result2', 'student_id', 'result'], 'integer'],
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
            'student_id' => 'Student ID',
            'result' => 'Result',
        ];
    }

    public function getStudent()
    {
        return $this->hasOne(Student::className(), ['id' => 'student_id']);
    }
}
