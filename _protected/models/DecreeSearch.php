<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * DecreeSearch represents the model behind the search form about `app\models\Decree`.
 */
class DecreeSearch extends Decree
{
    public $lecturer_id;
    public $student_id;
    public $categoryName;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'decree_category_id'], 'integer'],
            [['title', 'number', 'date', 'categoryName'], 'safe'],
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
        $query = Decree::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // make categoryName name sortable
        $dataProvider->sort->attributes['categoryName'] = [
            'asc' => ['decree_category.name' => SORT_ASC],
            'desc' => ['decree_category.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // for activating search based on category name
        $query->joinWith('decreeCategory');

        // to activate search based on lecturer_id
        $query->joinWith(['hasDecrees'], false); // false in second parameter means lazy loading

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'date' => $this->date,
            'decree_category_id' => $this->decree_category_id,
        ])->andFilterWhere(['has_decree.lecturer_id' => $this->lecturer_id])
            ->andFilterWhere(['has_decree.student_id' => $this->student_id]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'number', $this->number])
            ->andFilterWhere(['like', 'decree_category.name', $this->categoryName]);

        $query->orFilterWhere(['for_all_lecturer' => $this->for_all_lecturer])
            ->orFilterWhere(['for_all_student' => $this->for_all_student]);

        return $dataProvider;
    }
}
