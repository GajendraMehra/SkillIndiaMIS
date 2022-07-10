<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TransDetail as TransDetailModel;

/**
 * TransDetail represents the model behind the search form of `app\models\TransDetail`.
 */
class TransDetail extends TransDetailModel
{
    /**
     * {@inheritdoc}
     */
    public $user;
    public $batch_name,$tp_name,$tc_name,$tp_sid,$tc_sid,$batch_sip_id;
    public function rules()
    {
        return [
            [['id','user','tp_sid','batch_sip_id','tc_sid', 'batch_id', 'claim_type', 'status', 'tc_id', 'updated_by'], 'integer'],
            [['message_admin', 'message_accountant', 'created_at', 'updated_at'], 'safe'],
            [['batch_name','tp_name','tc_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = TransDetailModel::find();
        $query->innerJoin("tbl_target_batch", "tbl_target_batch.id=trans_details.batch_id");
        $query->innerJoin("tbl_tcdetail", "tbl_tcdetail.id=tbl_target_batch.tc_id");
        $query->innerJoin("tbl_tpartner_detail", "tbl_tcdetail.tp_id=tbl_tpartner_detail.id");

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder'=>['id' => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $addSortAttributes = ['tp_name','batch_sip_id','tc_name','tp_sid','tc_sid','batch_name'];
        foreach ($addSortAttributes as $addSortAttribute) {
        $dataProvider->sort->attributes[$addSortAttribute] = [
            'asc' => [$addSortAttribute => SORT_ASC],
            'desc' => [$addSortAttribute => SORT_DESC],
            'label' => $this->getAttributeLabel($addSortAttribute),
        ];
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'trans_details.id' => $this->id,
            'batch_id' => $this->batch_id,
            'tbl_target_batch.sip_id' => $this->batch_sip_id,
            'claim_type' => $this->claim_type,
            'tp_sdms_id' => $this->tp_sid,
            'smart_tcid' => $this->tc_sid,
            'trans_details.status' => $this->status,
            'created_at' => $this->created_at,
            'trans_details.tc_id' => $this->tc_id,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);
        if ($this->user==3) {
            # code...
            $query->andWhere(['in', 'trans_details.status', [1,4,3]]);
        }
        $query->andFilterWhere(['like', 'message_admin', $this->message_admin])
            ->andFilterWhere(['like', 'batch_name', $this->batch_name])
            ->andFilterWhere(['like', 'tp_name', $this->tp_name])
            ->andFilterWhere(['like', 'name', $this->tc_name]);

        return $dataProvider;
    }
}
