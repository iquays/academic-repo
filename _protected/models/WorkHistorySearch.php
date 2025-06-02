<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * WorkHistorySearch represents the model behind the search form about `app\models\WorkHistory`.
 */
class WorkHistorySearch extends WorkHistory
{
    public $cityName;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'profile_id'], 'integer'],
            [['title', 'workplace', 'city_id', 'start_date', 'end_date', 'cityName'], 'safe'],
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
        $query = WorkHistory::find();

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

        // to enable search based city name
        $query->joinWith(['city']);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'profile_id' => $this->profile_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'workplace', $this->workplace])
//            ->andFilterWhere(['like', 'city_id', $this->city_id])
            ->andFilterWhere(['like', 'regency.name', $this->cityName]);

        return $dataProvider;
    }
}
