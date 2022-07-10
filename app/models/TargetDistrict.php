<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_target_district".
 *
 * @property int $id
 * @property int $target_id
 * @property int $district_id
 */
class TargetDistrict extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_target_district';
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
            [['target_id', 'district_id'], 'required'],
            [['target_id', 'district_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'target_id' => 'Target ID',
            'district_id' => 'District ID',
        ];
    }

    public function getCities()
    {
        return $this->hasOne(UkDistrict::className(), ['id' => 'district_id']);
    }
}
