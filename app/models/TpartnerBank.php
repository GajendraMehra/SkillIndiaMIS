<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_tpartner_bank".
 *
 * @property int $id
 * @property string $account_number
 * @property string $ifsc_code
 * @property string $bank_name
 * @property string $account_name
 * @property string $created_at
 * @property string $updated_at
 * @property int $edited_by
 * @property int $tp_id
 */
class TpartnerBank extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_tpartner_bank';
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
            [['account_number', 'ifsc_code', 'bank_name', 'account_name', 'created_at', 'updated_at', 'edited_by', 'tp_id'], 'required'],
            [['ifsc_code', 'bank_name', 'account_name'], 'string'],
            array(['ifsc_code', 'bank_name', 'account_name'],'match', 'pattern'=>"/^([A-Za-z0-9 _-]*)$/", ),

            [['created_at', 'updated_at'], 'safe'],
            [['edited_by', 'tp_id'], 'integer'],
            // [['account_number'], 'string', 'max' => 255],
            [['ifsc_code'],'match', 'pattern' => "/^[A-Za-z]{4}0[A-Z0-9a-z]{6}$/", 'enableClientValidation' => false,'message' => 'Invalid IFSC CODE'],
            [['account_name'], 'string', 'min' => 6,'max' => 60],
            [['bank_name'], 'string', 'min' => 3,'max' => 30],
            [['account_number'], 'string', 'min' => 6,'max' => 20],
        ];
    }

    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'account_number' => 'Account Number',
            'ifsc_code' => 'IFSC Code',
            'bank_name' => 'Bank Name',
            'account_name' => 'Account Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'edited_by' => 'Edited By',
            'tp_id' => 'Tp ID',
        ];
    }
}
