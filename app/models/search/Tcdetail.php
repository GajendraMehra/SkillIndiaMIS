<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tcdetail as TcdetailModel;

/**
 * Tcdetail represents the model behind the search form of `app\models\Tcdetail`.
 */
class Tcdetail extends TcdetailModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'is_pmkk', 'tcenter_type', 'is_hostel', 'hostel_capacity', 'status', 'tp_id', 'edited_by'], 'integer'],
            [['name', 'smart_tcid', 'created_at', 'updated_at'], 'safe'],
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
        $query = TcdetailModel::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'is_pmkk' => $this->is_pmkk,
            'tcenter_type' => $this->tcenter_type,
            'is_hostel' => $this->is_hostel,
            'hostel_capacity' => $this->hostel_capacity,
            'status' => $this->status,
            'tp_id' => $this->tp_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'edited_by' => $this->edited_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'smart_tcid', $this->smart_tcid]);

        return $dataProvider;
    }
}
