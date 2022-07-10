<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TargetBatch as TargetBatchModel;

/**
 * TargetBatch represents the model behind the search form of `app\models\TargetBatch`.
 */
class TargetBatch extends TargetBatchModel
{
    /**
     * {@inheritdoc}
     */
    public $type,$tp_id;
    public function rules()
    {
        return [
            [['id','tp_id','sip_id', 'training_type','final_submit','type', 'min_size','tc_id', 'max_size','job_id', 'edited_by'], 'integer'],
            [['batch_name','job_id', 'trainer_name', 'created_at', 'updated_at'], 'safe'],
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
       
        $query = TargetBatchModel::find();
        $query->innerJoin("tbl_tcdetail", "tbl_tcdetail.id=tbl_target_batch.tc_id");

        switch ($params['type']) {
            case '0':
                $query->where([
                    '<=','end_date',date('Y-m-d')]);
                
            break;
            case '1':
                $query->where([ '<=','start_date',date('Y-m-d'), ]);
                $query->andWhere([  '>=','end_date',date('Y-m-d') ]);
            break;
            case '2':
                $query->where([
                    '>','start_date',date('Y-m-d'),
                 ]);    
            break;  
            
            default:
                # code...
            break;
        }
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
            'id' => $this->id,
            'training_type' => $this->training_type,
            'min_size' => $this->min_size,
            'sip_id'=>$this->sip_id,
            'max_size' => $this->max_size,
            'tc_id' => $this->tc_id,
            'tp_id' => $this->tp_id,
            'job_id' => $this->job_id,
            
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            // 'assesment_date' => $this->assesment_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'edited_by' => $this->edited_by,
        ]);

        $query->andFilterWhere(['like', 'batch_name', $this->batch_name])
            ->andFilterWhere(['like', 'trainer_name', $this->trainer_name])
            ->andFilterWhere(['>=', 'final_submit' , $this->final_submit]);

        return $dataProvider;
    }
}
