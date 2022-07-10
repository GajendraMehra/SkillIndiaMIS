<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_tpartner_invoice".
 *
 * @property int $id
 * @property int $tp_id
 * @property int $orgtype_id
 * @property int $org_id
 * @property string $pan
 * @property string|null $tan
 * @property int $status
 * @property int $smart_id
 * @property string $reg_date
 * @property string $created_at
 * @property string $updated_at
 * @property int $edited_by
 */
class TpartnerInvoice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_tpartner_invoice';
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
            [['tp_id', 'orgtype_id', 'org_id', 'pan', 'status', 'smart_id', 'reg_date', 'created_at', 'updated_at', 'edited_by'], 'required'],
            [['tp_id', 'orgtype_id', 'status', 'edited_by'], 'integer'],
            [['pan', 'tan','org_id'], 'string'],
            [['reg_date', 'created_at', 'updated_at'], 'safe'],
            // [['pan'],'match', 'pattern' => "/[A-Z]{5}[0-9]{4}[A-Z]{1}/",'enableClientValidation' => false,],
            [['pan'], 'string', 'min' => 10,'max'=>10],
            [['smart_id'], 'string', 'min' => 6,'max'=>15],
            [['pan'], 'string', 'min' => 10],
            [['org_id'], 'string', 'min' => 4,'max'=>20],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'orgtype_id' => 'Organization Type',
            'org_id' => 'Organization Identifier No',
            'pan' => 'PAN',
            'tan' => 'TAN',
            'status' => 'Status',
            'smart_id' => 'Smart TP ID',
            'reg_date' => 'Company Reg Date',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'edited_by' => 'Edited By',
        ];
    }
}
