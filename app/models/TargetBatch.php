<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_target_batch".
 *
 * @property int $id
 * @property string $batch_name
 * @property int $training_type
 * @property int $min_size
 * @property int $max_size
 * @property string $start_date
 * @property string $end_date
 * @property string $start_time
 * @property string $end_time
 * @property string $assesment_date
 * @property string $trainer_name
 * @property int $tc_id
 * @property int $job_id
 * @property int $sub_target_id
 * @property int $final_submit
 * @property string $created_at
 * @property string $updated_at
 * @property int $edited_by
 */
class TargetBatch extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_target_batch';
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
            [['batch_name','sip_id', 'training_type', 'min_size', 'max_size', 'start_date', 'end_date', 'start_time', 'end_time', 'assesment_date', 'trainer_name', 'tc_id', 'job_id', 'sub_target_id', 'created_at', 'updated_at', 'edited_by'], 'required'],
            [['training_type', 'min_size', 'max_size', 'tc_id', 'job_id', 'sub_target_id', 'final_submit', 'edited_by'], 'integer'],
            [['start_date', 'end_date', 'start_time', 'end_time', 'assesment_date', 'created_at', 'updated_at'], 'safe'],
            [['batch_name', 'trainer_name','sip_id'], 'string', 'min'=>3, 'max' => 100],
            [['batch_name', 'trainer_name'], 'string','min'=>5, 'max' => 100],
            [['sip_id'], 'unique'],

            // [['batch_name'], 'string', 'max' => 50],
            // array('min_size','compare','compareAttribute'=>'max_size','operator'=>'<','message'=>'Minimum Batch Size is less than Maximum Batch Size'),
            array('max_size','compare','compareAttribute'=>'min_size','type'=>'number','operator'=>'>','message'=>'Minimum Batch Size is less than or equal to Maximum Batch Size'),
            array('end_date','compare','compareAttribute'=>'start_date','operator'=>'>','message'=>'End Date can not be less than or equal to Start Date'),
            // array('end_time','compare','compareAttribute'=>'start_time','operator'=>'>','message'=>'End Time can not be less than or equal to Start Time'),
            array('assesment_date','compare','compareAttribute'=>'end_date','operator'=>'>','message'=>'Assesment  Date can not be less than or equal to Batch End Date'),
            // array('end_time','compare','compareAttribute'=>'start_time','operator'=>'>','message'=>'End Time can not be less than or equal to Start time'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'batch_name' => 'Batch Name',
            'sip_id'=>"Batch SIP ID",
            'training_type' => 'Training Type',
            'min_size' => 'Min Size',
            'max_size' => 'Max Size',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'assesment_date' => 'Assesment Date (Temp.)',
            'trainer_name' => 'Trainer Name',
            'tc_id' => 'Tc ID',
            'job_id' => 'Job Name',
            'sub_target_id' => 'Sub Target ID',
            'final_submit' => 'Final Submit',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'edited_by' => 'Edited By',
        ];
    }

    public function beforeValidate() {
     
         
        return parent::beforeValidate();
    }
    public function beforeSave($insert) {
        $this->start_time= date("H:i", strtotime( $this->start_time));
        $this->end_time= date("H:i", strtotime( $this->end_time));
    
          return parent::beforeSave($insert);
    
        }

        public function getEditedBy()
        {
            return $this->hasOne(Users::className(), ['id' => 'edited_by']);
        }
        
         public function getCenter()
        {
            return $this->hasOne(Tcdetail::className(), ['id' => 'tc_id']);
        }
        public function getTrainingType()
        {
            return $this->hasOne(BatchTrainingType::className(), ['id' => 'training_type']);
        }
        
        public function getJobs()
        {
            return $this->hasOne(Job::className(), ['id' => 'job_id']);
        }
        public function getSubTarget()
        {
            return $this->hasOne(TargetsResponse::className(), ['id' => 'sub_target_id']);
        }

        public function getSubSector()
        {
            // return 1;
              return $this->hasOne(SubSector::className(), ['nsdc_sub_sector_id' => 'sub_sector_id'])
              ->viaTable('tbl_jobs', ['id' => 'job_id']);

        }
         public function getBatchstudent()
        {
            // return 1;
              return $this->hasMany(BatchStudents::className(), ['batch_id' => 'id']);

        }
}
