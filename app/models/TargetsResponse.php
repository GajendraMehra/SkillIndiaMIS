<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_targets_response".
 *
 * @property int $id
 * @property int $target_id
 * @property int $tc_id
 * @property int $district_id
 * @property int $job_id
 * @property int $response_number
 * @property string $created_at
 * @property string $updated_at
 * @property int $edited_by
 */
class TargetsResponse extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_targets_response';
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
            [['target_id','tp_id', 'tc_id', 'district_id','job_id','status', 'response_number', 'created_at', 'updated_at', 'edited_by'], 'required'],
            [['target_id', 'tc_id','tp_id', 'district_id','job_id','status', 'response_number', 'edited_by'], 'integer'],
            [['action_id'], 'string','min'=>5, 'max' => 50],

            [['created_at', 'updated_at'], 'safe'],
            [['action_id'], 'string', 'max' => 255],
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
            'tc_id' => 'Tc ID',
            'status' => 'Approved Status',
            'district_id' => 'District ID',
            'job_id' => 'Job ID',
         
            'response_number' => 'Response Number',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'edited_by' => 'Edited By',
        ];
    }

    public function getCenter()
    {
        return $this->hasOne(Tcdetail::className(), ['id' => 'tc_id']);
    }
    public function getTarget()
    {
        return $this->hasOne(Targets::className(), ['id' => 'target_id']);
    }

    public function getJob($id="")
    {
        return $this->hasOne(Job::className(), ['id' => 'job_id']);

    }
    public function getSubSector()
    {
        // return 1;
          return $this->hasOne(SubSector::className(), ['nsdc_sub_sector_id' => 'sub_sector_id'])
          ->viaTable('tbl_jobs', ['id' => 'job_id']);

    }
    

    public function getDistrict($id="")
    {
        return $this->hasOne(UkDistrict::className(), ['id' => 'district_id']);

    }


    public function getEditedBy()
    {
        return $this->hasOne(Users::className(), ['id' => 'edited_by']);
    }
}
