<?php

namespace app\models\search;
use yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Targets as TargetsModel;
use app\models\CommonModel;;

/**
 * Targets represents the model behind the search form of `app\models\Targets`.
 */
class Targets extends TargetsModel
{
    /**
     * {@inheritdoc}
     */
    public $qp_code;
    public $district_id;
    public $job_id;
    public function rules()
    {
        return [
            [['id', 'tp_id','year','job_id','district_id', 'number','scheme_id','status','qp_code', 'edited_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
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
        $tpdetails=CommonModel::getTpdetailbyuserid();
        $query = TargetsModel::find()->select('tbl_targets.*,tbl_targets_response.id as tsid')
        ->innerJoin('tbl_target_district', 'tbl_targets.id = tbl_target_district.target_id')
        ->innerJoin('tbl_target_job', 'tbl_targets.id = tbl_target_job.target_id');
        
        if ($tpdetails) {
            $query->where(['tbl_targets.tp_id'=>$tpdetails['id']]);
            # code...
        }
        // ->groupBy(['scheme_id']);
        if ($params['filter']=='applied') {
            $query->innerJoin('tbl_targets_response', 'tbl_targets.id = tbl_targets_response.target_id');

        }  
        if ($params['filter']=='apply') {

            // TargetsResponse::find()->where('target_id'=>)
            $query->leftJoin('tbl_targets_response', 'tbl_targets.id = tbl_targets_response.target_id');
            $query->where(['tbl_targets_response.id'=>null]);

        } if ($params['filter']=='all') {
            $query->leftJoin('tbl_targets_response', 'tbl_targets.id = tbl_targets_response.target_id');


        }

    //     echo "<pre>";
    //   var_dump($query->asArray()->all());
    //   die;

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]]
        ]);
        $this->load($params);

        $addSortAttributes = ["qp_code"];
        foreach ($addSortAttributes as $addSortAttribute) {
        $dataProvider->sort->attributes[$addSortAttribute] = [
            'asc' => [$addSortAttribute => SORT_ASC],
            'desc' => [$addSortAttribute => SORT_DESC],
            'label' => $this->getAttributeLabel($addSortAttribute),
        ];
        }
        // if (!$this->validate()) {
        //     // uncomment the following line if you do not want to return any records when validation fails
        //     // $query->where('0=1');
        //     return $dataProvider;
        // }
        // if (!preg_match( '/UK\b/', $this->id)) {
        //    $this->id=0;
        // }
        
       
        // grid filtering conditions
        $query->andFilterWhere([
            'tbl_targets.id' => $this->id,
            
            // 'qp_code' => $this->qp_code,
            'scheme_id' => $this->scheme_id,
            'tbl_targets.status' => $this->status,
            'tbl_target_district.district_id' => $this->district_id,
            'tbl_target_job.job_id' => $this->job_id,
            
            'tbl_targets.tp_id' => $this->tp_id,
            'number' => $this->number,
            'created_at' => $this->created_at,
            'year'=>$this->year,
            'updated_at' => $this->updated_at,
            // 'edited_by' => $this->edited_by,
        ]);
        $query->andFilterWhere(['like', 'tbl_jobs.qp_code', $this->qp_code]);
        // $query->andFilterWhere(['!=', 'tsid', null]);

        return $dataProvider;
    }
     public function search1($params)
    {
        $query = TargetsModel::find()
        ->groupBy(['scheme_id']);
     

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_ASC]],
            'pagination' => false,
        ]);

        $this->load($params);
        $addSortAttributes = ["qp_code"];
        foreach ($addSortAttributes as $addSortAttribute) {
        $dataProvider->sort->attributes[$addSortAttribute] = [
            'asc' => [$addSortAttribute => SORT_ASC],
            'desc' => [$addSortAttribute => SORT_DESC],
            'label' => $this->getAttributeLabel($addSortAttribute),
        ];
        }
        // if (!$this->validate()) {
        //     // uncomment the following line if you do not want to return any records when validation fails
        //     // $query->where('0=1');
        //     return $dataProvider;
        // }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            // 'qp_code' => $this->qp_code,
            'scheme_id' => $this->scheme_id,
         
            'tp_id' => $this->tp_id,
            'number' => $this->number,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'edited_by' => $this->edited_by,
        ]);
        $query->andFilterWhere(['like', 'tbl_jobs.qp_code', $this->qp_code]);

        return $dataProvider;
    }
}
