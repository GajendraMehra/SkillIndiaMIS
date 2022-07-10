<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_ibm_response".
 *
 * @property int $id
 * @property string $response_data
 */
class IbmResponse extends \yii\db\ActiveRecord
{ 
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_ibm_response';
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
            [['response_data'], 'required'],
            [['response_data'], 'string'],
            [['batch_id', 'read_status'], 'integer'],
            [['message', 'response_data'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'response_data' => 'Response Data',
            'read_status' => 'Status',
        ];
    }
}
 