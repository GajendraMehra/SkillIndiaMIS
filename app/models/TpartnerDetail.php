<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_tpartner_detail".
 *
 * @property int $id
 * @property string $tp_name
 * @property int $tp_sdms_id
 * @property int $has_gst
 * @property string $gst_no
 * @property string $created_at
 * @property string $updated_at
 * @property int $edited_by
 * @property int $final_submit
 * @property int $is_approved
 */
class TpartnerDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_tpartner_detail';
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
            [['tp_name','tp_sdms_id', 'has_gst', 'created_at', 'updated_at', 'edited_by'], 'required'],
            [['tp_name', 'gst_no'], 'string'],
            array(['tp_name', 'gst_no'],'match', 'pattern'=>"/^([A-Za-z0-9 _-]*)$/", ),
            [[ 'has_gst', 'edited_by', 'final_submit', 'is_approved'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            array(['tp_sdms_id'],'match', 'pattern' => "/^TP[0-9]+/",'message'=>"SDMS ID should be like TP001212" ),
            [['tp_sdms_id'], 'unique'],
            [['tp_name'], 'string', 'min' => 6 ,'max'=>60],
            [['gst_no'],'required','when' => function($model) { return $model->has_gst == 1; }, 'enableClientValidation' => false,], [['gst_no'],'match', 'pattern' => "/^([0-9]){2}([A-Za-z]){5}([0-9]){4}([A-Za-z]){1}([0-9]{1})([A-Za-z]){2}?$/",'when' => function($model) { return $model->has_gst == 1; }, 'enableClientValidation' => false,'message' => 'Invalid GST number'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tp_name' => 'Training Partner Name',
            'tp_sdms_id' => 'SDMS ID',
            'has_gst' => 'Do you have GST',
            'gst_no' => 'GST No',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'edited_by' => 'User',
            'final_submit' => 'Final Submit',
            'is_approved' => 'Approve Status',
        ];
    }
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['id' => 'edited_by']);
    }
    public function getTpspoc()
    {
        return $this->hasOne(TpdetailSpocfinance::className(), ['tp_id' => 'id']);
    } public function getTpaddress()
    {
        return $this->hasOne(TpdetailAddress::className(), ['tp_id' => 'id']);
    }
}
