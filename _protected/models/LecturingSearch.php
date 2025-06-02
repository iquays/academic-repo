<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * LecturingSearch represents the model behind the search form about `app\models\Lecturing`.
 */
class LecturingSearch extends Lecturing
{
    public $lecturerName;
    public $courseName;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'lecturer_id', 'course_id', 'semester', 'status'], 'integer'],
            [['year', 'lecturerName', 'courseName'], 'safe'],
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
        $query = Lecturing::find();

        // add conditions that should always apply here


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // make lecturerName name sortable
        $dataProvider->sort->attributes['lecturerName'] = [
            'asc' => ['lecturer.name' => SORT_ASC],
            'desc' => ['lecturer.name' => SORT_DESC],
        ];

        // make courseName name sortable
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

        $query->joinWith(['lecturer', 'course']);
//        $query->joinWith('course');

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'lecturer_id' => $this->lecturer_id,
            'course_id' => $this->course_id,
            'year' => $this->year,
            'semester' => $this->semester,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'lecturer.name', $this->lecturerName])
            ->andFilterWhere(['like', 'course.name', $this->courseName]);

        return $dataProvider;
    }
}
