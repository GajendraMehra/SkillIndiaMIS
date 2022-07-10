<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Job as JobModel;

/**
 * Job represents the model behind the search form of `app\models\Job`.
 */
class Job extends JobModel
{
    /**
     * {@inheritdoc}
     */
    public $sector_id;

    public function rules()
    {
        return [
            [['id', 'sub_sector_id', 'sector_id','nsqf_level', 'theory_hour', 'practical_hour', 'softskill_hour', 'not_payable', 'net_hours', 'edited_by'], 'integer'],
            [['job_name', 'qp_code', 'qualification', 'created_at', 'updated_at'], 'safe'],
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
        $query = JobModel::find()
        ->innerJoin('tbl_sub_sectors', 'tbl_sub_sectors.nsdc_sub_sector_id = tbl_jobs.sub_sector_id')
        ->innerJoin('tbl_sectors', 'tbl_sectors.nsdc_sector_id = tbl_sub_sectors.sector_id');

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
        $addSortAttributes = ["sector_id"];
        foreach ($addSortAttributes as $addSortAttribute) {
        $dataProvider->sort->attributes[$addSortAttribute] = [
            'asc' => [$addSortAttribute => SORT_ASC],
            'desc' => [$addSortAttribute => SORT_DESC],
            'label' => $this->getAttributeLabel($addSortAttribute),
        ];
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'sub_sector_id' => $this->sub_sector_id,
            'tbl_sectors.nsdc_sector_id' => $this->sector_id,
            'nsqf_level' => $this->nsqf_level,
            'theory_hour' => $this->theory_hour,
            'practical_hour' => $this->practical_hour,
            'softskill_hour' => $this->softskill_hour,
            'not_payable' => $this->not_payable,
            'net_hours' => $this->net_hours,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'edited_by' => $this->edited_by,
        ]);

        $query->andFilterWhere(['like', 'job_name', $this->job_name])
            ->andFilterWhere(['like', 'qp_code', $this->qp_code])
            ->andFilterWhere(['like', 'qualification', $this->qualification]);

        return $dataProvider;
    }
}
