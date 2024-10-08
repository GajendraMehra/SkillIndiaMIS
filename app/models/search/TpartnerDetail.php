<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TpartnerDetail as TpartnerDetailModel;

/**
 * TpartnerDetail represents the model behind the search form of `app\models\TpartnerDetail`.
 */
class TpartnerDetail extends TpartnerDetailModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tp_sdms_id', 'has_gst', 'edited_by', 'final_submit', 'is_approved'], 'integer'],
            [['tp_name', 'gst_no', 'created_at', 'updated_at'], 'safe'],
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
        $query = TpartnerDetailModel::find();

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
            'tp_sdms_id' => $this->tp_sdms_id,
            'has_gst' => $this->has_gst,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'edited_by' => $this->edited_by,
            'final_submit' => $this->final_submit,
            'is_approved' => $this->is_approved,
        ]);

        $query->andFilterWhere(['like', 'tp_name', $this->tp_name])
            ->andFilterWhere(['like', 'gst_no', $this->gst_no]);

        return $dataProvider;
    }
}
