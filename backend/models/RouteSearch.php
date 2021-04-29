<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Route;

/**
 * RouteSearch represents the model behind the search form of `common\models\Route`.
 */
class RouteSearch extends Route
{
	public $title;
	
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'content_id', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Route::find();
        $query->leftJoin('route_translation', 'route_translation.route_id = route.id');
        $query->groupBy(['route.id', 'route_translation.title']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
				'defaultOrder' => ['id' => SORT_DESC]
			],
            'pagination' => [
				'pageSize' => 50,
			]
        ]);
        
        $dataProvider->sort->attributes['title'] = [
			'asc' => ['route_translation.title' => SORT_ASC],
			'desc' => ['route_translation.title' => SORT_DESC],
		];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'route.id' => $this->id,
            'content_id' => $this->content_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
        
        $query->andFilterWhere(['ilike', 'route_translation.title', $this->title]);

        return $dataProvider;
    }
}
