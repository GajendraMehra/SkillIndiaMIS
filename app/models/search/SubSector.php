<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SubSector as SubSectorModel;

/**
 * SubSector represents the model behind the search form of `app\models\SubSector`.
 */
class SubSector extends SubSectorModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'sector_id', 'nsdc_sub_sector_id'], 'integer'],
            [['sub_sector_name'], 'safe'],
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
        $query = SubSectorModel::find();

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
        $dataProvider->sort->defaultOrder = ['nsdc_sub_sector_id' => SORT_ASC];


        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'sector_id' => $this->sector_id,
            'nsdc_sub_sector_id' => $this->nsdc_sub_sector_id,
        ]);

        $query->andFilterWhere(['like', 'sub_sector_name', $this->sub_sector_name]);

        return $dataProvider;
    }
}
