<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * LecturingHistorySearch represents the model behind the search form about `app\models\LecturingHistory`.
 */
class LecturingHistorySearch extends LecturingHistory
{
    public $courseName;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'course_id', 'level'], 'integer'],
            [['institution', 'year', 'courseName'], 'safe'],
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
        $query = LecturingHistory::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // make courseName sortable
        $dataProvider->sort->attributes['courseName'] = [
            'asc' => ['course.name' => SORT_ASC],
            'desc' => ['course.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // for activating search based on course name
        $query->joinWith('course');

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
//            'course_id' => $this->course_id,
            'level' => $this->level,
            'year' => $this->year,
        ]);

        $query->andFilterWhere(['like', 'institution', $this->institution])
            ->andFilterWhere(['like', 'course.name', $this->courseName]);

        return $dataProvider;
    }
}
