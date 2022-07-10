<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Sector as SectorModel;

/**
 * Sector represents the model behind the search form of `app\models\Sector`.
 */
class Sector extends SectorModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id','nsdc_sector_id'], 'integer'],
            [['sector_name'], 'safe'],
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
        $query = SectorModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            
        ]);
        $dataProvider->sort->defaultOrder = ['nsdc_sector_id' => SORT_ASC];
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'sector_name', $this->sector_name]);

        return $dataProvider;
    }
}
