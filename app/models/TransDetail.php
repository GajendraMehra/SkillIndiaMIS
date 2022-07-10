<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "trans_details".
 *
 * @property int $id
 * @property int $batch_id
 * @property int $claim_type
 * @property int $status
 * @property string $message_admin
 * @property string $message_accountant
 * @property string $created_at
 * @property int $tc_id
 * @property string $updated_at
 * @property int $updated_by
 */
class TransDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    public static function tableName()
    {
        return 'trans_details';
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
            [['batch_id', 'claim_type', 'status', 'created_at', 'tc_id', 'updated_at', 'updated_by'], 'required'],
            [['batch_id','claim_type','is_tds_deduct', 'status', 'tc_id', 'updated_by','rate_info_id'], 'integer'],
            [['batch_id', 'claim_type'], 'unique', 'targetAttribute' => ['batch_id', 'claim_type'],'message'=>'You already claimed for this Batch and Tranche Stage'],
            [['message_admin', 'message_accountant'], 'string'],
            array(['message_admin', 'message_accountant'],'match', 'pattern'=>"/^([A-Za-z0-9 _-]*)$/", ),

            [['created_at', 'updated_at'], 'safe'],
            [['net_amount','trans_percent'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'batch_id' => 'Batch Name',
            'claim_type' => 'Tranche Stage',
            'is_tds_deduct' => 'Deduct TDS ?',
            'status' => 'Status',
            'message_admin' => 'Message Admin',
            'message_accountant' => 'Remark (If any)',
            'created_at' => 'Created At',
            'tc_id' => 'Training Center',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
    public function getBatch()
    {
        return $this->hasOne(TargetBatch::className(), ['id' => 'batch_id']);
    }  
    public function getTc()
    {
        return $this->hasOne(Tcdetail::className(), ['id' => 'tc_id']);
    }
    public function getTcbank()
    {
        return $this->hasOne(TcenterBank::className(), ['tc_id' => 'tc_id']);
    }
    public function getRateinfo()
    {
        return $this->hasOne(RateInfo::className(), ['id' => 'rate_info_id']);
    }
}
