<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_sub_sectors".
 *
 * @property int $id
 * @property string $sub_sector_name
 * @property int $sector_id
 * @property int $nsdc_sub_sector_id
 */
class SubSector extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_sub_sectors';
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
            [['sub_sector_name', 'sector_id', 'nsdc_sub_sector_id'], 'required'],
            [['sub_sector_name'], 'string'],
            array(['sub_sector_name'],'match', 'pattern'=>"/^([A-Za-z0-9 _-]*)$/", ),

            [['sector_id', 'nsdc_sub_sector_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sub_sector_name' => 'Sub Sector Name',
            'sector_id' => 'Parent Sector',
            'nsdc_sub_sector_id' => 'NSDC Sub Sector ID',
        ];
    }


    public function getSector()
    {
        return $this->hasOne(Sector::className(), ['nsdc_sector_id' => 'sector_id']);
    }

}
