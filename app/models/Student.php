<?php

namespace app\models;
use app\models\TcenterAddress;
use Yii;

/**
 * This is the model class for table "tbl_student".
 *
 * @property int $id
 * @property string $hope_id
 * @property string $student_name
 * @property string $email
 * @property string $mother_name
 * @property string $father_name
 * @property string $dob
 * @property string $aadhar_no
 * @property string $address
 * @property int $block_id
 * @property string $phone_no
 * @property int $max_edu
 * @property int $category
 * @property int $prefrence_job
 * @property int $i_agree
 * @property string $created_at
 * @property string $updated_at
 * @property int $edited_by
 */
class Student extends \yii\db\ActiveRecord
{

  public $district_id;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_student';
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
    public $adhar_file;

    public function rules()
    {
        return [
            [['adhar_file'], 'file','skipOnEmpty' => true,  'extensions' => 'png, jpg,pdf,jpeg,xls,docx,doc','maxSize'=>1024*1024*3],
            // [['adhar_file'], 'required', 'on'=> 'create'],
            [['sip_id'],'match', 'pattern' => "/^CAN_[0-9]+/",'message'=>"SIP ID should be like CAN_121895624"],

            [['adhar_file_name'], 'string', 'max' => 50],
            // [['hope_id'], 'number','message'=>'Hope ID should be like 202198548000001915'],
            [['sip_id','student_name', 'email', 'mother_name', 'father_name', 'dob', 'gender', 'aadhar_no', 'address', 'pin_code', 'block_id', 'phone_no', 'max_edu', 'category', 'religion', 'is_disabled', 'prefrence_job', 'prefrence_district', 'selected_tc', 'i_agree', 'created_at', 'updated_at', 'edited_by'], 'required'],
            [['dob', 'created_at', 'updated_at'], 'safe'],
            [['gender', 'block_id', 'max_edu', 'category', 'religion', 'is_disabled', 'prefrence_job', 'prefrence_district', 'selected_tc', 'i_agree', 'edited_by'], 'integer'],
            [['pin_code', 'phone_no'], 'string'],
            [['email', 'aadhar_no','employment_id','sip_id'], 'string','min'=>3, 'max' => 30],
            [['student_name', 'mother_name', 'father_name'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 255],
            [['disbality'], 'string', 'max' => 100],
            [['email','aadhar_no'], 'unique'],
            // [['email'], 'unique'],
            array('email', 'email', 'message'=>'Email is not valid'),
            [['employment_id','sip_id'], 'unique'],
            [['phone_no'], 'unique'],
            [['phone_no'], 'string', 'min' => 10,'max'=>11],
            [['aadhar_no'],'match', 'pattern' => "/^([0-9]){12}$/"],
            ['i_agree', 'compare', 'compareValue' => 0, 'operator' => '>','message'=>"Please agree terms and conditions"],
            [['disbality'],'required','when' => function($model) { return $model->is_disabled == 1; }, 'enableClientValidation' => false],
            array(['student_name','mother_name','father_name','address'],'match', 'pattern'=>"/^([A-Za-z0-9 _-]*)$/", ),
            



        ];
    }
   

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hope_id' => 'HOPE ID',
            'employment_id'=>"Employment ID",
            'sip_id'=>"SIP ID",
            'student_name' => 'Student Full Name',
            'email' => 'Email',
            'mother_name' => 'Mother\'s Full Name',
            'father_name' => 'Father\'s Name',
            'dob' => 'Date of Birth',
            'aadhar_no' => 'Aadhar No',
            'address' => 'Address',
            'block_id' => 'Block Name',
            'gender'=>'Gender',
            'phone_no' => 'Phone No',
            'max_edu' => 'Education Qualification',
            'category' => 'Category',
            'prefrence_job' => 'Prefered Job',
            'selected_tc' => 'Selected Training Center ',
            'prefrence_district' => 'Prefered District',
            'i_agree' => 'I Agree',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'edited_by' => 'Edited By',
        ];
    }

    public function upload()
    {
        
        if ($this->validate()) {
            $ext = (explode(".",$this->adhar_file->name));
            // generate a unique file name to prevent duplicate filenames
            $this->adhar_file_name = Yii::$app->security->generateRandomString().".".end($ext);
         
            $this->adhar_file->saveAs('uploads/aadhar/files/'. $this->adhar_file_name,$this->adhar_file->baseName . '.' . $this->adhar_file->extension);
            return  'uploads/aadhar/files/'.$this->adhar_file_name;
        } else {
            return false;
        }
    }
public function beforeSave($insert) {
    $this->student_name=ucwords($this->student_name);
    $this->mother_name=ucwords($this->mother_name);
    $this->father_name=ucwords($this->father_name);
    $this->email=strtolower($this->email);
    $this->address=ucwords($this->address);
      return parent::beforeSave($insert);

    }

    public function getJob()
    {
        return $this->hasOne(Job::className(), ['id' => 'prefrence_job']);
    }
    public function getBlock()
    {
        return $this->hasOne(UkBlocks::className(), ['id' => 'block_id']);
    }
    public function getDistrict()
    {
        return $this->hasOne(UkDistrict::className(), ['id' => 'district_id']);
    }

    public function getCategoryname()
    {
        return $this->hasOne(Category::className(), ['id' => 'category']);
    }
    public function getEducationlevel()
    {
        return $this->hasOne(EducationLevel::className(), ['id' => 'max_edu']);
    }


    public function getEditedby()
    {
        return $this->hasOne(Users::className(), ['id' => 'edited_by']);
    }
    public function getTrainingcenters()
    {
        return $this->hasOne(Tcdetail::className(), ['id' => 'selected_tc']);
    }


}
