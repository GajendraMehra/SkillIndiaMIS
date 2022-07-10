<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_batch_students".
 *
 * @property int $id
 * @property int $batch_id
 * @property int $student_id
 * @property string $created_at
 */
class BatchStudents extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public function behaviors()
    {
        return [
            [
                'class' => TrimBehavior::className(),
            ],
        ];
    }
    public static function tableName()
    {
        return 'tbl_batch_students';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['batch_id', 'student_id', 'created_at'], 'required'],
            [['batch_id', 'student_id'], 'integer'],
            [['created_at'], 'safe'],
            [['batch_id', 'student_id'], 'unique', 'targetAttribute' => ['batch_id', 'student_id']],
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
            'created_at' => 'Created At',
        ];
    }
    
    public function getStudent()
    {
        return $this->hasOne(Student::className(), ['id' => 'student_id']);
    } 
    public function getStudentresult()
    {
        return $this->hasOne(StudentResult::className(), ['student_id' => 'student_id','batch_id'=>'batch_id']);
    } 
    public function getStudentplacement()
    {
        return $this->hasOne(StudentPlacement::className(), ['student_id' => 'student_id','batch_id'=>'batch_id']);
    }
    public function getTrans()
    {
        return $this->hasMany(TransDetail::className(), ['batch_id' => 'batch_id']);
    }

    
}
