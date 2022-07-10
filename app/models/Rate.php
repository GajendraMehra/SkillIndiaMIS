<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_rate".
 *
 * @property int $id
 * @property string $rate_name
 * @property string $created_at
 * @property string $updated_at
 * @property int $edited_by
 */
class Rate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_rate';
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
            [['rate_name', 'created_at', 'updated_at', 'edited_by'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['edited_by'], 'integer'],
            [['rate_name'], 'string', 'max' => 50],
            ['rate_name','match',  'pattern' => '/^[a-zA-Z\s]+$/'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rate_name' => 'Rate Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'edited_by' => 'Edited By',
        ];
    }

    public function getEditedBy()
    {
        return $this->hasOne(Users::className(), ['id' => 'edited_by']);
    }
}
