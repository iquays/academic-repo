<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * StudentSearch represents the model behind the search form about `app\models\Student`.
 */
class StudentSearch extends Student
{
    public $entrySemester;
    public $userName;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'profile_id', 'entry_semester'], 'integer'],
            [['nim', 'name', 'entry_year', 'graduation_date', 'entrySemester', 'userName'], 'safe'],
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
        $query = Student::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // make userName name sortable
        $dataProvider->sort->attributes['userName'] = [
            'asc' => ['user.username' => SORT_ASC],
            'desc' => ['user.username' => SORT_DESC],
        ];

        // make entrySemester sortable
        $dataProvider->sort->attributes['entry_semester'] = [
            'asc' => ['user.username' => SORT_ASC],
            'desc' => ['user.username' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith('user');

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'profile_id' => $this->profile_id,
            'entry_year' => $this->entry_year,
            'entry_semester' => $this->entry_semester,
            'graduation_date' => $this->graduation_date,
        ]);

        $query->andFilterWhere(['like', 'nim', $this->nim])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'user.username', $this->userName]);

        return $dataProvider;
    }
}
