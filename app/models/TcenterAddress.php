<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_tcenter_address".
 *
 * @property int $id
 * @property string $address_line
 * @property string $post_office
 * @property string|null $village
 * @property int $pin_code
 * @property int $state_id
 * @property int $city_id
 * @property string $created_at
 * @property string $updated_at
 * @property int $edited_by
 * @property int $tc_id
 */
class TcenterAddress extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_tcenter_address';
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
            [['address_line', 'post_office', 'pin_code', 'state_id', 'city_id', 'created_at', 'updated_at', 'edited_by', 'tc_id'], 'required'],
            [['pin_code', 'state_id', 'city_id', 'edited_by', 'tc_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['address_line',], 'string', 'min' => 6 , 'max' => 255],
            array(['address_line'],'match', 'pattern'=>"/^([A-Za-z0-9 _-]*)$/", ),
            
            [['post_office', 'village'], 'string', 'min' => 3,'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'address_line' => 'Address Line',
            'post_office' => 'Post Office',
            'village' => 'Village',
            'pin_code' => 'Pin Code',
            'state_id' => 'State Name',
            'city_id' => 'City Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'edited_by' => 'Edited By',
            'tc_id' => 'tc ID',
        ];
    }


    public function getTrainingcenters()
    {
        return $this->hasOne(UkDistrict::className(), ['id' => 'city_id']);
    }
    public function getTc()
    {
        return $this->hasOne(Tcdetail::className(), ['id' => 'tc_id']);
    }
}
