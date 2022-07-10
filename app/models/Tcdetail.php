<?php

namespace app\models;

use Yii;
use app\models\Users;
/**
 * This is the model class for table "tbl_tcdetail".
 *
 * @property int $id
 * @property string $name
 * @property string $smart_tcid
 * @property int $is_pmkk
 * @property int $tcenter_type
 * @property int $is_hostel
 * @property int|null $hostel_capacity
 * @property int $status
 * @property int $tp_id
 * @property string $created_at
 * @property string $updated_at
 * @property int $edited_by
 */
class Tcdetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_tcdetail';
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
         // $this->addError('email','This id, category and language already exist');

           return [
               [['name', 'email', 'smart_tcid', 'is_pmkk', 'tcenter_type', 'is_hostel', 'status', 'tp_id', 'created_at', 'updated_at', 'edited_by'], 'required'],
               [['name', ], 'string'],
                array(['name'],'match', 'pattern'=>"/^([A-Za-z0-9 _-]*)$/", ),
                array(['smart_tcid'],'match', 'pattern' => "/^TC[0-9]+/",'message'=>"SMART ID should be TC1212" ),
                [['smart_tcid','email'], 'unique'],
               [['is_pmkk', 'tcenter_type', 'is_hostel', 'hostel_capacity', 'status', 'tp_id', 'edited_by'], 'integer'],
               [['created_at', 'updated_at'], 'safe'],
               [['email'], 'string', 'max' => 50],
            //    ['email','custom_function_validation', 'skipOnEmpty' => false, ]
             ];

       }


    //    public function custom_function_validation($attribute){
    //     $this->addError('email','This id, category and language already exist');
    //        if ($this->$attribute < $this->cash_amount)
    //            $this->addError($attribute,'Credit amount should less than Bill amount.');
    //    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Center Name',
            'smart_tcid' => 'SMART TCID',
            'is_pmkk' => 'PMKK',
            'tcenter_type' => 'Center Type',
            'is_hostel' => 'Hostel Avaliablity',
            'hostel_capacity' => 'Hostel Capacity',
            'status' => 'Status',
            'tp_id' => 'Tp ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'edited_by' => 'Edited By',
        ];
    }
    public function getParenttp() {
            return $this->hasOne(TpartnerDetail::className(), ['id' => 'tp_id']);
    }
    public function  getTcspoc()
    {
        return $this->hasOne(TcenterSpocoperation::className(), ['tc_id' => 'id']);
    } public function  getTcaddress()
    {
        return $this->hasOne(TcenterAddress::className(), ['tc_id' => 'id']);
    }

}
