<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * LecturerSearch represents the model behind the search form about `app\models\Lecturer`.
 */
class LecturerSearch extends Lecturer
{
    public $userName;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'profile_id'], 'integer'],
            [['nip', 'name', 'userName'], 'safe'],
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
        $query = Lecturer::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // make userName name sortable
        $dataProvider->sort->attributes['userName'] = [
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
        ]);

        $query->andFilterWhere(['like', 'nip', $this->nip])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'user.username', $this->userName]);

        return $dataProvider;
    }
}
