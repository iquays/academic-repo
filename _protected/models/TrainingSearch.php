<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TrainingSearch represents the model behind the search form about `app\models\Training`.
 */
class TrainingSearch extends Training
{
    public $cityName;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'profile_id'], 'integer'],
            [['name', 'organizer', 'city_id', 'start_date', 'end_date', 'certificate', 'cityName'], 'safe'],
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
        $query = Training::find();

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

        // for activating search based on city/regency name
        $query->joinWith('city');

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'profile_id' => $this->profile_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'organizer', $this->organizer])
//            ->andFilterWhere(['like', 'city_id', $this->city_id])
            ->andFilterWhere(['like', 'certificate', $this->certificate])
            ->andFilterWhere(['like', 'regency.name', $this->cityName]);
        return $dataProvider;
    }
}
