<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BatchStudents as BatchStudentsModel;

/**
 * BatchStudents represents the model behind the search form of `app\models\BatchStudents`.
 */
class BatchStudents extends BatchStudentsModel
{
    /**
     * {@inheritdoc}
     */
    public $reclaim,$result1;
    public function rules()
    {
        return [
            [['id','reclaim','result1', 'batch_id', 'student_id'], 'integer'],
            [['created_at'], 'safe'],
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
        $query = BatchStudentsModel::find()
        ->leftJoin('student_result', 'tbl_batch_students.student_id = student_result.student_id');

        

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        $this->load($params);
  
if($this->reclaim==1){
$query->andWhere(['>', 'LENGTH(result1)', 0]);
// $query->andWhere(['==', 'result1', 1]);
// $query->andWhere(['==', 'result1', 2]);
}
if($this->reclaim==2){
    $query->andWhere(['>', 'LENGTH(result2)', 0]);
    // $query->andWhere(['==', 'result1', 1]);
    // $query->andWhere(['==', 'result1', 2]);
    }
// die;
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'tbl_batch_students.batch_id' => $this->batch_id,
            'student_id' => $this->student_id,
            'result1' => $this->result1,
            // 'reclaim' => $this->reclaim,
            'created_at' => $this->created_at,
        ]);

        return $dataProvider;
    }
}
