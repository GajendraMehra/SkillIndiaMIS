<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "student_placement".
 *
 * @property int $id
 * @property int $batch_id
 * @property int $student_id
 * @property int $result
 * @property string $placed_organisation
 * @property int $package_pm
 *
 * @property Student $student
 * @property TargetBatch $batch
 */
class StudentPlacement extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'student_placement';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['batch_id', 'student_id', 'result'], 'required'],
            [['batch_id', 'student_id', 'result', 'package_pm'], 'integer'],
            [['placed_organisation'], 'string', 'max' => 255],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => Student::className(), 'targetAttribute' => ['student_id' => 'id']],
            [['batch_id'], 'exist', 'skipOnError' => true, 'targetClass' => TargetBatch::className(), 'targetAttribute' => ['batch_id' => 'id']],
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
            'placed_organisation' => 'Placed Organisation',
            'package_pm' => 'Package Pm',
        ];
    }

    /**
     * Gets query for [[Student]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(Student::className(), ['id' => 'student_id']);
    }

    /**
     * Gets query for [[Batch]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBatch()
    {
        return $this->hasOne(TargetBatch::className(), ['id' => 'batch_id']);
    }
}
