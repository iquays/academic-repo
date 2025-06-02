<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CommunityServiceSearch represents the model behind the search form about `app\models\CommunityService`.
 */
class CommunityServiceSearch extends CommunityService
{
    public $profile_id;
    public $cityName;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['title', 'place', 'city_id', 'funding_source', 'date', 'cityName'], 'safe'],
            [['funding_amount'], 'number'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = CommunityService::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // make city_name sortable
        $dataProvider->sort->attributes['cityName'] = [
            'asc' => ['regency.name' => SORT_ASC],
            'desc' => ['regency.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // to activate search based on profile_id
        $query->joinWith('communityServicings');

        // to activate search based on city name
        $query->joinWith('city');


        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'funding_amount' => $this->funding_amount,
            'date' => $this->date,
        ])->andFilterWhere(['community_servicing.profile_id' => $this->profile_id]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'place', $this->place])
//            ->andFilterWhere(['like', 'city_id', $this->city_id])
            ->andFilterWhere(['like', 'regency.name', $this->cityName])
            ->andFilterWhere(['like', 'funding_source', $this->funding_source]);

        return $dataProvider;
    }
}
