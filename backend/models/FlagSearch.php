<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Flag;

/**
 * FlagSearch represents the model behind the search form of `common\models\Flag`.
 */
class FlagSearch extends Flag
{
	public $title;
	
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'flag_group_id', 'order', 'created_at', 'updated_at'], 'integer'],
            [['hidden', 'label'], 'boolean'],
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
        $query = Flag::find();
        $query->leftJoin('flag_translation', 'flag_translation.flag_id = flag.id');
        $query->groupBy(['flag.id', 'flag_translation.title']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
				'defaultOrder' => ['order' => SORT_ASC]
			],
            'pagination' => [
				'pageSize' => 50,
			]
        ]);
        
        $dataProvider->sort->attributes['title'] = [
			'asc' => ['flag_translation.title' => SORT_ASC],
			'desc' => ['flag_translation.title' => SORT_DESC],
		];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'flag.id' => $this->id,
            'flag_group_id' => $this->flag_group_id,
            'hidden' => $this->hidden,
            'label' => $this->label,
            'order' => $this->order,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
        
        $query->andFilterWhere(['ilike', 'flag_translation.title', $this->title]);

        return $dataProvider;
    }
}
