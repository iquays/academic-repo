<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * StudyingSearch represents the model behind the search form about `app\models\Studying`.
 */
class StudyingSearch extends Studying
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'lecturing_id', 'student_id', 'mark', 'status'], 'integer'],
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
        $query = Studying::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'lecturing_id' => $this->lecturing_id,
            'student_id' => $this->student_id,
            'mark' => $this->mark,
            'status' => $this->status,
        ]);

        return $dataProvider;
    }
}
