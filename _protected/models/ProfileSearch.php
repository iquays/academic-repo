<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ProfileSearch represents the model behind the search form about `app\models\Profile`.
 */
class ProfileSearch extends Profile
{
    public $birthPlace_name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'marital_status', 'work_status', 'almamater_acreditation', 'study_period', 'is_civitas'], 'integer'],
            [['picture', 'name', 'birth_place', 'birth_date', 'institution', 'almamater_id', 'mandatory_workplace', 'handphone_number', 'lat', 'lng', 'birthPlace_name'], 'safe'],
            [['gpa_degree', 'gpa_profession'], 'number'],
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
        $query = Profile::find();

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

        // for activating search based on city/regency name
        $query->joinWith('birthPlace');

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'birth_date' => $this->birth_date,
            'marital_status' => $this->marital_status,
            'work_status' => $this->work_status,
            'almamater_acreditation' => $this->almamater_acreditation,
            'gpa_degree' => $this->gpa_degree,
            'gpa_profession' => $this->gpa_profession,
            'study_period' => $this->study_period,
            'is_civitas' => $this->is_civitas,
        ]);

        $query->andFilterWhere(['like', 'profile.name', $this->name])
            ->andFilterWhere(['like', 'institution', $this->institution])
            ->andFilterWhere(['like', 'mandatory_workplace', $this->mandatory_workplace])
            ->andFilterWhere(['like', 'handphone_number', $this->handphone_number])
            ->andFilterWhere(['like', 'regency.name', $this->birthPlace_name]);

        return $dataProvider;
    }
}
