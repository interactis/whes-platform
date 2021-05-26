<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\FlagGroup;

/**
 * FlagGroupSearch represents the model behind the search form of `common\models\FlagGroup`.
 */
class FlagGroupSearch extends FlagGroup
{
	public $title;
	
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'order', 'created_at', 'updated_at'], 'integer'],
            [['hidden'], 'boolean'],
            [['title', 'operator'], 'safe'],
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
        $query = FlagGroup::find();
        $query->leftJoin('flag_group_translation', 'flag_group_translation.flag_group_id = flag_group.id');
        $query->groupBy(['flag_group.id', 'flag_group_translation.title']);

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
			'asc' => ['flag_group_translation.title' => SORT_ASC],
			'desc' => ['flag_group_translation.title' => SORT_DESC],
		];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'flag_group.id' => $this->id,
            'order' => $this->order,
            'hidden' => $this->hidden,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
		
		$query->andFilterWhere(['ilike', 'flag_group_translation.title', $this->title]);
		$query->andFilterWhere(['ilike', 'operator', $this->operator]);
		
        return $dataProvider;
    }
}
