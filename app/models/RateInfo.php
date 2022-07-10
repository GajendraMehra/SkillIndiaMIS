<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_rate_info".
 *
 * @property int $id
 * @property int $rate_id
 * @property float $rate_amount
 * @property string $fromdate
 * @property string $created_at
 * @property string $updated_at
 * @property int $edited_by
 *
 * @property TblRate $rate
 */
class RateInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_rate_info';
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
            [['rate_id', 'rate_amount', 'fromdate', 'created_at', 'updated_at', 'edited_by'], 'required'],
            [['rate_id', 'edited_by'], 'integer'],
            [['rate_amount'], 'number'],
            [['fromdate', 'created_at', 'updated_at'], 'safe'],
            [['rate_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rate::className(), 'targetAttribute' => ['rate_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rate_id' => 'Rate ID',
            'rate_amount' => 'Rate Amount',
            'fromdate' => 'Fromdate',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'edited_by' => 'Edited By',
        ];
    }

    /**
     * Gets query for [[Rate]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRate()
    {
        return $this->hasOne(Rate::className(), ['id' => 'rate_id']);
    }

    public function getEditedBy()
    {
        return $this->hasOne(Users::className(), ['id' => 'edited_by']);
    }
}
