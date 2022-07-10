<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_sectors".
 *
 * @property int $id
 * @property string $sector_name
 */
class Sector extends \yii\db\ActiveRecord
{
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
    public static function tableName()
    {
        return 'tbl_sectors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sector_name'], 'required'],
            [['sector_name'], 'string','max' => 30, 'min' => 2,],
            ['sector_name','match',  'pattern' => '/^[a-zA-Z\s]+$/'],
         
            [['nsdc_sector_id'], 'integer'],
            [['nsdc_sector_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sector_name' => 'Sector Name',
            'nsdc_sector_id' => 'NSDC Sector Id',
        ];
    }

   



}
