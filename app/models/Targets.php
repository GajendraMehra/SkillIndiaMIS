<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_targets".
 *
 * @property int $id
 * @property int $job_id
 * @property int $tp_id
 * @property int $number
 * @property string $created_at
 * @property string $updated_at
 * @property int $edited_by
 *
 * @property TblScheme $scheme
 * @property TblTpartnerDetail $tp
 * @property User $editedBy
 */
class Targets extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $imageFile;
    public static function tableName()
    {
        return 'tbl_targets';
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
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg,pdf,jpeg','maxSize'=>'5242880'],
            [['tp_id','year', 'scheme_id', 'number', 'created_at', 'updated_at', 'edited_by'], 'required'],
            [['tp_id', 'scheme_id','year', 'number', 'edited_by','status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['work_order_file'], 'string', 'max' => 255],
            [['tp_id'], 'exist', 'skipOnError' => true, 'targetClass' => TpartnerDetail::className(), 'targetAttribute' => ['tp_id' => 'id']],
            [['edited_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['edited_by' => 'id']],
            [['scheme_id'], 'exist', 'skipOnError' => true, 'targetClass' => Scheme::className(), 'targetAttribute' => ['scheme_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'imageFile' => 'Work Order File',
            'tp_id' => 'Training Partner',
            'number' => 'Target',
            'status' => 'Target Status',
            'created_at' => 'Created At',
            'work_order_file' => 'Work Order File',
            'updated_at' => 'Updated At',
            'year'=>"Finanace Year",
            'edited_by' => 'Edited By',
            'scheme_id' => 'Scheme Name',
        ];
    }

    public function upload()
    {
        
        if ($this->validate()) {
            $ext = (explode(".",$this->imageFile->name));
            // generate a unique file name to prevent duplicate filenames
            $this->work_order_file = Yii::$app->security->generateRandomString().".".end($ext);
         
            $this->imageFile->saveAs('uploads/workorder/'. $this->work_order_file,$this->imageFile->baseName . '.' . $this->imageFile->extension);
            return  'uploads/workorder/'.$this->work_order_file;
        } else {
            return false;
        }
    }
    /**
     * Gets query for [[Scheme]].
     *
     * @return \yii\db\ActiveQuery
     */
 
  

    public function getScheme()
    {
        return $this->hasOne(Scheme::className(), ['id' => 'scheme_id']);
    }
    /**
     * Gets query for [[Tp]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTp()
    {
        return $this->hasOne(TpartnerDetail::className(), ['id' => 'tp_id']);
    }
    public function getJobs($id="")
    {
        return   TargetJob::find()
        ->select('tbl_jobs.*')
        ->innerJoin('tbl_targets','tbl_target_job.target_id=tbl_targets.id')
        ->innerJoin('tbl_jobs','tbl_jobs.id=tbl_target_job.job_id')
        ->where(['tbl_targets.id'=>$id])
        ->asArray()
        ->all();
    }
    public function getDistricts($id="")
    {
        return   Targets::find()
        ->select('*')
        ->innerJoin('tbl_target_district','tbl_target_district.target_id=tbl_targets.id')
        ->innerJoin('districts','tbl_target_district.district_id=districts.id')
        ->where(['tbl_targets.id'=>$id])
        ->asArray()
        ->all();
    }
public function getTableJobName()

{

	return $this->hasMany(Job::className(), ['id' => 'job_id']);

}

    /**
     * Gets query for [[EditedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEditedBy()
    {
        return $this->hasOne(Users::className(), ['id' => 'edited_by']);
    }  
     public function getPending()
    {
        return $this->hasOne(TargetsResponse::className(), ['target_id' => 'id',]);
    }  
   
}
