<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Heritage;

/**
 * HeritageSearch represents the model behind the search form of `common\models\Heritage`.
 */
class HeritageSearch extends Heritage
{
	public $name;
	
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'priority', 'created_at', 'updated_at'], 'integer'],
            [['geom'], 'safe'],
            [['published', 'hidden'], 'boolean'],
            [['name'], 'safe'],
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
        $query = Heritage::find();
        $query->leftJoin('heritage_translation', 'heritage_translation.heritage_id = heritage.id');
        $query->groupBy(['heritage.id', 'heritage_translation.name']);

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
        
        $dataProvider->sort->attributes['name'] = [
			'asc' => ['heritage_translation.name' => SORT_ASC],
			'desc' => ['heritage_translation.name' => SORT_DESC],
		];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'priority' => $this->priority,
            'published' => $this->published,
            'hidden' => $this->hidden,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'heritage_translation.name', $this->name]);

        return $dataProvider;
    }
}
