<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PublicationSearch represents the model behind the search form about `app\models\Publication`.
 */
class PublicationSearch extends Publication
{
    public $profile_id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by'], 'integer'],
            [['title', 'publication_name', 'volume_number', 'year', 'file_paper'], 'safe'],
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
        $query = Publication::find();

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
        $query->joinWith('publicatings');


        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'year' => $this->year,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ])->andFilterWhere(['publicating.profile_id' => $this->profile_id]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'publication_name', $this->publication_name])
            ->andFilterWhere(['like', 'volume_number', $this->volume_number])
            ->andFilterWhere(['like', 'file_paper', $this->file_paper]);

        return $dataProvider;
    }
}
