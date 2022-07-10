<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_accountant_data".
 *
 * @property int $id
 * @property string $file_title
 * @property string $file_description
 * @property string $file_name
 * @property int $edited_by
 * @property string $created_at
 * @property string $updated_at
 */
class AccountantData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $file_image;
    public static function tableName()
    {
        return 'tbl_accountant_data';
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
            [['file_image'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg,pdf,jpeg,xls,docx,doc','maxSize'=>'5242880'],
            [['file_title', 'file_description', 'edited_by', 'created_at', 'updated_at'], 'required'],
            [['edited_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['file_title'], 'string', 'max' => 100],
            [['file_description'], 'string', 'max' => 250],
            [['file_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file_title' => 'File Title',
            'file_description' => 'File Description',
            'file_name' => 'File Name',
            'edited_by' => 'Edited By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    public function upload()
    {
        
        if ($this->validate()) {
            $ext = (explode(".",$this->file_image->name));
            // generate a unique file name to prevent duplicate filenames
            $this->file_name = Yii::$app->security->generateRandomString().".".end($ext);
         
            $this->file_image->saveAs('uploads/accountant/files/'. $this->file_name,$this->file_image->baseName . '.' . $this->file_image->extension);
            return  'uploads/accountant/files/'.$this->file_name;
        } else {
            return false;
        }
    }
    public function getEditedBy()
    {
        return $this->hasOne(Users::className(), ['id' => 'edited_by']);
    }
}
