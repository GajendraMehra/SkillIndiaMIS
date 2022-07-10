<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Student as StudentModel;

/**
 * Student represents the model behind the search form of `app\models\Student`.
 */
class Student extends StudentModel
{

      public $district_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['block_id', 'max_edu', 'category', 'prefrence_job','selected_tc','gender', 'i_agree', 'edited_by'], 'integer'],

            [['hope_id','employment_id','sip_id', 'student_name', 'email', 'mother_name', 'father_name', 'dob', 'aadhar_no', 'address', 'phone_no', 'created_at', 'updated_at'], 'safe'],
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
        $query = StudentModel::find();
        // $query->innerJoin("tbl_student", "districts.id=.block_id");
        $query->innerJoin("tbl_blocks", "tbl_student.block_id=tbl_blocks.id");
     $query->innerJoin("districts", "districts.id=tbl_blocks.district_id");
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder'=>['id' => SORT_DESC]]

        ]);

        $this->load($params);

        // if (!$this->validate()) {
        //     // uncomment the following line if you do not want to return any records when validation fails
        //     // $query->where('0=1');
        //     return $dataProvider;
        // }

        // grid filtering conditions
        $query->andFilterWhere([
            'tbl_student.id' => $this->id,
            'dob' => $this->dob,
            'employment_id' => $this->employment_id,
            'block_id' => $this->block_id,
            'district_id' => $this->district_id,
            'gender' => $this->gender,
            'sip_id' => $this->sip_id,
            'max_edu' => $this->max_edu,
            'category' => $this->category,
            'prefrence_job' => $this->prefrence_job,
            'selected_tc' => $this->selected_tc,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'edited_by' => $this->edited_by,
        ]);

        $query->andFilterWhere(['like', 'hope_id', $this->hope_id])
            ->andFilterWhere(['like', 'student_name', $this->student_name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'mother_name', $this->mother_name])
            ->andFilterWhere(['like', 'father_name', $this->father_name])
            ->andFilterWhere(['like', 'aadhar_no', $this->aadhar_no])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'phone_no', $this->phone_no]);

        return $dataProvider;
    }
}
