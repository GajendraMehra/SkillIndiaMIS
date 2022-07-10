<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_tcenter_spocoperation".
 *
 * @property int $id
 * @property string $name
 * @property int $gender
 * @property string $designation
 * @property string $aadhar_no
 * @property string $mobile_no
 * @property string $email
 * @property string|null $landline_no
 * @property string $created_at
 * @property string $updated_at
 * @property int $edited_by
 * @property int $tc_id
 */
class TcenterSpocoperation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_tcenter_spocoperation';
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
            [['name', 'gender', 'designation', 'aadhar_no', 'mobile_no', 'email', 'created_at', 'updated_at', 'edited_by', 'tc_id'], 'required'],
            [['name', 'designation', 'aadhar_no', 'email'], 'string'],
            array(['name', 'designation'],'match', 'pattern'=>"/^([A-Za-z0-9 _-]*)$/", ),
            
            [['gender', 'edited_by', 'tc_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['mobile_no', 'landline_no'], 'string', 'max' => 45],
            [['mobile_no'],'match', 'pattern' => "/[2-9]{2}\d{8}/"],
            [['aadhar_no'],'match', 'pattern' => "/^([0-9]){12}$/"],
            [['designation'], 'string', 'min' => 6,'max' => 20],
            [['name'], 'string', 'min' => 6,'max' => 30],

            array('email', 'email', 'message'=>'Email is not valid'),
            array('email', 'unique',  'message'=>'This Email is already in use'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'gender' => 'Gender',
            'designation' => 'Designation',
            'aadhar_no' => 'Aadhar No',
            'mobile_no' => 'Mobile No',
            'email' => 'Email',
            'landline_no' => 'Landline No',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'edited_by' => 'Edited By',
            'tc_id' => 'tc ID',
        ];
    }
}
