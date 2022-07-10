<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_target_job".
 *
 * @property int $id
 * @property int $target_id
 * @property int $job_id
 *
 * @property TblTargets $target
 */
class TargetJob extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_target_job';
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
            [['target_id', 'job_id'], 'required'],
            [['target_id', 'job_id'], 'integer'],
            [['target_id'], 'exist', 'skipOnError' => true, 'targetClass' => Targets::className(), 'targetAttribute' => ['target_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'target_id' => 'Target ID',
            'job_id' => 'Job ID',
        ];
    }

    /**
     * Gets query for [[Target]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTarget()
    {
        return $this->hasOne(Targets::className(), ['id' => 'target_id']);
    }

    public function getJobs()
    {
        return $this->hasOne(Job::className(), ['id' => 'job_id']);
    }
}
