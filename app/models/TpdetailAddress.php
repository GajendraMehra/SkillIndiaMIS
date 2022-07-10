<?php

namespace app\models;
use app\models\TrimBehavior;
use Yii;

/**
 * This is the model class for table "tbl_tpdetail_address".
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
 * @property int $tp_id
 */
class TpdetailAddress extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public function behaviors()
    {
        return [
            [
                'class' => TrimBehavior::className(),
            ],
        ];
    }
    public static function tableName()
    {
        return 'tbl_tpdetail_address';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['address_line', 'post_office', 'pin_code', 'state_id', 'city_id', 'created_at', 'updated_at', 'edited_by', 'tp_id'], 'required'],
            [['post_office', 'village'], 'string'],
            array(['post_office', 'village'],'match', 'pattern'=>"/^([A-Za-z0-9 _-]*)$/", ),
            
            [['pin_code', 'state_id', 'city_id', 'edited_by', 'tp_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['address_line'], 'string', 'max' => 50],
            [['pin_code'], 'string', 'min' => 6,'max' => 10],
            // [['pin_code'], 'integer', 'min' => 6],
            [['address_line',], 'string', 'min' => 6],
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
            'village' => 'Village Name',
            'pin_code' => 'Pin Code',
            'state_id' => 'State Name',
            'city_id' => 'City Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'edited_by' => 'Edited By',
            'tp_id' => 'Tp ID',
        ];
    }

    
    public function getCity()
    {
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
    }
}
