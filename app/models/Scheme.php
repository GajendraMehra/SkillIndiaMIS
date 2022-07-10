<?php

namespace app\models;

use Yii;

/**
 * 
 * 
 *
 * @property int $id
 * @property string $short_name
 * @property string $full_name
 * @property string|null $description
 * @property string $created_at
 * @property string $updated_at
 * @property int $edited_by
 */
class Scheme extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_scheme';
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
            [['short_name', 'full_name', 'created_at', 'updated_at', 'edited_by'], 'required'],
            [['short_name'], 'string'],
            array(['short_name','full_name','description'],'match', 'pattern'=>"/^([A-Za-z0-9 _.-]*)$/"),
            [['created_at', 'updated_at'], 'safe'],
            [['edited_by'], 'integer'],
            [['full_name'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'short_name' => 'Short Name',
            'full_name' => 'Full Name',
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'edited_by' => 'Edited By',
        ];
    }
    public function getEditedBy()
    {
        return $this->hasOne(Users::className(), ['id' => 'edited_by']);
    }
    public function getJobs($id="")
    {
        return SchemeJobs::find()->where(['scheme_id'=>$id])->asArray()->one();
    }

   
}
