<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ResearchSearch represents the model behind the search form about `app\models\Research`.
 */
class ResearchSearch extends Research
{
    public $profile_id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'year'], 'integer'],
            [['title', 'funding_source'], 'safe'],
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
        $query = Research::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // to activate search based on profile_id
        $query->joinWith('researchings');


        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'funding_amount' => $this->funding_amount,
            'year' => $this->year,
        ])->andFilterWhere(['researching.profile_id' => $this->profile_id]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'funding_source', $this->funding_source]);

        return $dataProvider;
    }
}
