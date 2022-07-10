<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\StudentResult as StudentResultModel;

/**
 * StudentResult represents the model behind the search form of `app\models\StudentResult`.
 */
class StudentResult extends StudentResultModel
{
    /**
     * {@inheritdoc}
     */
    public $claim;
    public function rules()
    {
        return [
            [['id','claim', 'batch_id', 'student_id', 'result','result1','result2'], 'integer'],
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
        $query = StudentResultModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            'sort' => ['defaultOrder'=>['id' => SORT_DESC]]

        ]);
        if ($this->reclaim==3) {
            $query->orWhere([
                'or',
                ['=','result', 1],
                ['=','result1', 1],
                ['=','result2', 1],
            ]);
        }
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'batch_id' => $this->batch_id,
            'result1' => $this->result1,
            'student_id' => $this->student_id,
            'result' => $this->result,
        ]);

        return $dataProvider;
    }
}
