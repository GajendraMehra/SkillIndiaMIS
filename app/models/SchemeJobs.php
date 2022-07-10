<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_scheme_jobs".
 *
 * @property int $id
 * @property int $scheme_id
 * @property int $job_id
 */
class SchemeJobs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_scheme_jobs';
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
            [['scheme_id', 'job_id'], 'required'],
            [['scheme_id', 'job_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'scheme_id' => 'Scheme ID',
            'job_id' => 'Jobs',
        ];
    }

    public function getSchemejobs()
    {
        return $this->hasOne(Job::className(), ['id' => 'job_id']);
    }
}
