<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_jobs".
 *
 * @property int $id
 * @property string $job_name
 * @property int $sub_sector_id
 * @property string $qp_code
 * @property int $nsqf_level
 * @property string $qualification
 * @property int $theory_hour
 * @property int $practical_hour
 * @property int $softskill_hour
 * @property int $not_payable
 * @property int $net_hours
 * @property string $created_at
 * @property string $updated_at
 * @property int $edited_by
 */
class Job extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_jobs';
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
            [['job_name', 'sub_sector_id', 'qp_code', 'nsqf_level', 'qualification', 'theory_hour', 'practical_hour', 'softskill_hour', 'not_payable', 'net_hours', 'created_at', 'updated_at', 'edited_by'], 'required'],
            [['job_name'], 'string'],
            ['job_name','match',  'pattern' => '/^[a-zA-Z\s]+$/'],
            [['sub_sector_id', 'nsqf_level', 'edited_by'], 'integer'],
            [['theory_hour', 'practical_hour', 'softskill_hour', 'not_payable', 'net_hours'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['qp_code'], 'string', 'max' => 50],
            [['qualification'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'job_name' => 'Job Name',
            'sub_sector_id' => 'Sub Sector',
            'qp_code' => 'QP Code',
            'nsqf_level' => 'MSQF Level',
            'qualification' => 'Qualification',
            'theory_hour' => 'Theory Hours',
            'practical_hour' => 'Practical Hours',
            'softskill_hour' => 'Softskill Hours',
            'not_payable' => 'Not Payable',
            'net_hours' => 'Net Hours',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'edited_by' => 'Edited By',
        ];
    }

    public function getSubSector()
    {
        return $this->hasOne(SubSector::className(), ['nsdc_sub_sector_id' => 'sub_sector_id']);
    }

    public function getSector() {
        return $this->hasMany(Sector::className(), ['nsdc_sector_id' => 'sector_id'])
          ->viaTable('tbl_sub_sectors', ['nsdc_sub_sector_id' => 'sub_sector_id']);
    }

    public function getEditedBy()
    {
        return $this->hasOne(Users::className(), ['id' => 'edited_by']);
    }
}
